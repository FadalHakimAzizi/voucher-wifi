<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CashflowAnalysis;
use App\Models\UsageHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua pembelian voucher (termasuk yang baru dibeli)
        $recentPurchases = CashflowAnalysis::where('user_id', Auth::id())
            ->with('voucher')
            ->latest()
            ->get();

        // Log untuk debugging
        Log::info('Recent Purchases for User:', [
            'user_id' => Auth::id(),
            'purchases_count' => $recentPurchases->count(),
            'purchases' => $recentPurchases->map(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'voucher_id' => $purchase->voucher_id,
                    'voucher_code' => optional($purchase->voucher)->code,
                    'amount' => $purchase->amount,
                    'payment_method' => $purchase->payment_method,
                    'transaction_date' => $purchase->transaction_date,
                ];
            })->toArray(),
        ]);

        // Ambil semua pembelian voucher yang belum diredeem
        $activeVouchers = CashflowAnalysis::where('user_id', Auth::id())
            ->with('voucher')
            ->whereHas('voucher', function ($query) {
                $query->where('is_redeemed', false);
            })
            ->get();

        // Log untuk debugging
        Log::info('Active Vouchers for User:', [
            'user_id' => Auth::id(),
            'active_vouchers_count' => $activeVouchers->count(),
            'active_vouchers' => $activeVouchers->map(function ($voucher) {
                return [
                    'id' => $voucher->id,
                    'voucher_id' => $voucher->voucher_id,
                    'voucher_code' => optional($voucher->voucher)->code,
                    'is_redeemed' => optional($voucher->voucher)->is_redeemed,
                ];
            })->toArray(),
        ]);

        // Ambil riwayat penggunaan untuk voucher yang sudah diredeem
        $redeemedVouchers = UsageHistory::where('user_id', Auth::id())
            ->with('voucher')
            ->get();

        // Hitung total durasi dari voucher yang dibeli
        $totalMinutes = $activeVouchers->sum(function ($purchase) {
            return $purchase->voucher->duration_minutes ?? 0;
        }) + $redeemedVouchers->sum(function ($history) {
            return $history->voucher->duration_minutes ?? 0;
        });

        // Hitung total sisa waktu dari voucher yang masih aktif
        $totalRemainingSeconds = 0;
        foreach ($redeemedVouchers as $history) {
            $expiresAt = Carbon::parse($history->expires_at);
            $now = Carbon::now();
            if ($now->lessThan($expiresAt)) {
                $remainingSeconds = $now->diffInSeconds($expiresAt, false);
                $totalRemainingSeconds += $remainingSeconds;
            }
        }

        return view('user.dashboard', [
            'recentPurchases' => $recentPurchases,
            'vouchers' => $activeVouchers,
            'redeemedVouchers' => $redeemedVouchers,
            'totalMinutes' => $totalMinutes,
            'redeemedCount' => $redeemedVouchers->count(),
            'totalRemainingTime' => gmdate('H:i:s', $totalRemainingSeconds),
        ]);
    }
}