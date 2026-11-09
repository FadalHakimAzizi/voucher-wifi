<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\VoucherCode;
use App\Models\CashflowAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function show($voucher)
    {
        $voucher = VoucherCode::findOrFail($voucher);
        return view('user.purchase', compact('voucher'));
    }

    public function process(Request $request, $voucher)
    {
        // Log incoming request data for debugging
        Log::info('Purchase Request Data:', $request->all());

        // Validasi input
        $validated = $request->validate([
            'payment_method' => 'required|in:bank_transfer,qris,ewallet',
        ]);

        $paymentMethod = $request->input('payment_method');
        Log::info('Processed Payment Method:', ['method' => $paymentMethod]);

        // Cari voucher
        $voucher = VoucherCode::findOrFail($voucher);

        // Cek apakah voucher sudah dibeli
        if ($voucher->cashflowAnalysis()->exists()) {
            return back()->with('error', 'Voucher ini sudah dibeli.');
        }

        // Simpan transaksi ke CashflowAnalysis
        CashflowAnalysis::create([
            'voucher_id' => $voucher->id,
            'user_id' => Auth::id(),
            'amount' => $voucher->price,
            'transaction_date' => now(),
            'payment_method' => $paymentMethod, // Gunakan nilai dari request
        ]);

        // Log informasi pembelian
        Log::info('Voucher Purchased Successfully:', [
            'voucher_id' => $voucher->id,
            'user_id' => Auth::id(),
            'payment_method' => $paymentMethod,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Voucher berhasil dibeli dengan metode pembayaran ' . $paymentMethod . '.');
    }
}