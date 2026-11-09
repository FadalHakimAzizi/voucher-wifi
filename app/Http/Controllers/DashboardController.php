<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VoucherCode;
use App\Models\CashflowAnalysis;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Voucher
        $totalVouchers = VoucherCode::count();
        $activeVouchers = VoucherCode::where('is_redeemed', false)
                                    ->where(function ($query) {
                                        $query->whereNull('expires_at')
                                              ->orWhere('expires_at', '>=', now());
                                    })->count();
        $pendingVouchers = VoucherCode::where('is_redeemed', false)
                                    ->whereNotNull('expires_at')
                                    ->where('expires_at', '<', now())
                                    ->count();
        $expiredVouchers = VoucherCode::where('is_redeemed', true)->count();

        // Recent Vouchers
        $recentVouchers = VoucherCode::with('creator')
                                    ->latest()
                                    ->limit(4)
                                    ->get()
                                    ->map(function ($voucher) {
                                        $voucher->usage_count = CashflowAnalysis::where('voucher_id', $voucher->id)->count();
                                        return $voucher;
                                    });

        // Chart Data: Penggunaan 30 Hari Terakhir
        $usageChartLabels = collect(range(0, 29))->map(function ($day) {
            return Carbon::now()->subDays($day)->format('d M');
        })->reverse()->values();
        $usageChartCreated = [];
        $usageChartUsed = [];
        foreach ($usageChartLabels as $label) {
            $date = Carbon::parse($label)->startOfDay();
            $usageChartCreated[] = VoucherCode::whereDate('created_at', $date)->count();
            $usageChartUsed[] = CashflowAnalysis::whereDate('transaction_date', $date)->count();
        }

        // Chart Data: Distribusi Voucher
        $distributionLabels = VoucherCode::select('duration_minutes')
                                       ->groupBy('duration_minutes')
                                       ->orderBy('duration_minutes')
                                       ->get()
                                       ->map(function ($voucher) {
                                           return $voucher->duration_minutes . ' Menit';
                                       })->values();
        $distributionData = VoucherCode::selectRaw('count(*) as count, duration_minutes')
                                     ->groupBy('duration_minutes')
                                     ->orderBy('duration_minutes')
                                     ->get()
                                     ->map(function ($voucher) use ($totalVouchers) {
                                         return round(($voucher->count / $totalVouchers) * 100, 2);
                                     })->values();

        return view('admin.dashboard', compact(
            'totalVouchers',
            'activeVouchers',
            'pendingVouchers',
            'expiredVouchers',
            'recentVouchers',
            'usageChartLabels',
            'usageChartCreated',
            'usageChartUsed',
            'distributionLabels',
            'distributionData'
        ));
    }
}