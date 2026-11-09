<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CashflowAnalysis;
use App\Models\UsageHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $purchases = CashflowAnalysis::where('user_id', $user->id)->with('voucher')->get();
        $usages = UsageHistory::where('user_id', $user->id)->with('voucher')->get();

        return view('user.history', compact('purchases', 'usages'));
    }
}
