<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VoucherCode;

class VoucherController extends Controller
{
    public function index()
{
    $voucherTypes = VoucherCode::select('id', 'duration_minutes', 'price')
        ->whereDoesntHave('cashflowAnalysis')
        ->get();

    return view('user.vouchers', compact('voucherTypes'));
}

    public function show($voucher)
{
    $voucher = VoucherCode::findOrFail($voucher); // Sesuaikan dengan model Anda
    return view('purchase', compact('voucher'));
}
}
