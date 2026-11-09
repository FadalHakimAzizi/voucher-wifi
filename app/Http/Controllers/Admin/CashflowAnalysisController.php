<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashflowAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashflowAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $transactions = CashflowAnalysis::with(['user', 'voucher'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        $totals = CashflowAnalysis::selectRaw("
                SUM(amount) as totalRevenue,
                SUM(CASE WHEN amount >= 0 THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN amount <  0 THEN amount ELSE 0 END) as expenses
            ")->first();

        $now = Carbon::now();
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $months->push($m);
        }

        $monthlySums = CashflowAnalysis::selectRaw("
                DATE_FORMAT(transaction_date, '%Y-%m') as ym,
                SUM(amount) as sum_amount
            ")
            ->where('transaction_date', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->pluck('sum_amount', 'ym');

        $chartLabels = $months->map(fn($m) => $m->format('M Y'))->toArray();
        $chartData = $months->map(fn($m) => (float) ($monthlySums->get($m->format('Y-m')) ?? 0))
                           ->toArray();

        $pm = CashflowAnalysis::selectRaw("
                payment_method,
                COUNT(*) as count_tx
            ")
            ->groupBy('payment_method')
            ->pluck('count_tx', 'payment_method');

        $paymentMethodsLabels = $pm->keys()->toArray();
        $paymentMethodsData = $pm->values()->map(fn($v) => (int)$v)->toArray();

        return view('admin.cashflow', [
            'transactions' => $transactions,
            'totalRevenue' => $totals->totalRevenue ?? 0,
            'income' => $totals->income ?? 0,
            'expenses' => abs($totals->expenses) ?? 0,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'paymentMethodsLabels' => $paymentMethodsLabels,
            'paymentMethodsData' => $paymentMethodsData,
        ]);
    }

    public function destroy(CashflowAnalysis $cashflow)
    {
        try {
            $cashflow->delete();

            return redirect()->route('admin.cashflow.index')
                           ->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}