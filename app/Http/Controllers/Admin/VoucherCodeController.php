<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VoucherCode;
use App\Models\Promotion;
use App\Models\CashflowAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherCodeController extends Controller
{
    public function index()
    {
        $vouchers = VoucherCode::with('promo')->latest()->get();
        $promotions = Promotion::orderBy('name')->get();

        return view('admin.voucher', compact('vouchers', 'promotions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:voucher_codes,code',
            'duration_minutes' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'promo_id' => 'nullable|exists:promotions,id',
            'expires_at' => 'nullable|date', // Validasi untuk expires_at
        ]);

        VoucherCode::create($data);

        return redirect()->route('admin.vouchers.index')
                         ->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function update(Request $request, VoucherCode $voucher)
    {
        $data = $request->validate([
            'code' => "required|string|unique:voucher_codes,code,{$voucher->id}",
            'duration_minutes' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'promo_id' => 'nullable|exists:promotions,id',
            'is_redeemed' => 'sometimes|boolean',
            'expires_at' => 'nullable|date', // Validasi untuk expires_at
        ]);

        $data['is_redeemed'] = $request->has('is_redeemed');

        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')
                         ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(VoucherCode $voucher)
    {
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
                         ->with('success', 'Voucher berhasil dihapus.');
    }

    public function show(VoucherCode $voucher)
    {
        return view('admin.voucher', compact('voucher'));
    }

    public function purchase(VoucherCode $voucher)
    {
        $cashflow = CashflowAnalysis::where('voucher_id', $voucher->id)->first();
        return view('admin.voucher', compact('voucher', 'cashflow'));
    }

    public function buy(Request $request, VoucherCode $voucher)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        CashflowAnalysis::create([
            'voucher_id' => $voucher->id,
            'user_id' => $request->user_id,
            'amount' => $voucher->price,
            'transaction_date' => now(),
            'status' => 'completed',
        ]);

        return redirect()->route('admin.vouchers.index')
                         ->with('success', 'Voucher berhasil dibeli untuk pengguna.');
    }
}