<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CashflowAnalysis;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $purchase = CashflowAnalysis::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('voucher')
            ->firstOrFail();

        return view('user.invoice', compact('purchase'));
    }
}