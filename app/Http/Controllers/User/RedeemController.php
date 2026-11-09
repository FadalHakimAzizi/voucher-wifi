<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\VoucherCode;
use App\Models\UsageHistory;
use Illuminate\Http\Request;
use App\Models\CashflowAnalysis;
use Carbon\Carbon;

class RedeemController extends Controller
{
    public function showForm()
    {
        return view('user.redeem');
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $voucher = VoucherCode::where('code', $request->code)->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'Kode voucher tidak ditemukan.');
        }

        if ($voucher->is_redeemed) {
            return redirect()->back()->with('error', 'Kode voucher sudah digunakan.');
        }

        // Pastikan voucher memiliki entri di cashflow_analysis
        $cashflow = $voucher->cashflowAnalyses()->where('user_id', Auth::id())->first();
        if (!$cashflow) {
            return redirect()->back()->with('error', 'Voucher belum dibeli atau bukan milik Anda.');
        }

        // Periksa apakah voucher sudah expired
        $expiresAt = Carbon::parse($cashflow->transaction_date)->addMinutes($voucher->duration_minutes);
        $now = Carbon::now();
        if ($now->greaterThan($expiresAt)) {
            return redirect()->back()->with('error', 'Voucher sudah kedaluwarsa dan tidak dapat diredeem.');
        }

        // Update status redeem
        $voucher->is_redeemed = true;
        $voucher->redeemed_at = Carbon::now();
        $voucher->save();

        // Simpan riwayat penggunaan dengan waktu independen
        $usage = UsageHistory::create([
            'voucher_id' => $voucher->id,
            'user_id' => Auth::id(),
            'redeemed_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes($voucher->duration_minutes),
            'start_time' => Carbon::now(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Voucher berhasil diredeem! Anda dapat menggunakan WiFi selama ' . $voucher->duration_minutes . ' menit.');
    }
}