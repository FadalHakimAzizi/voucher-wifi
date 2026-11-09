<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsageHistory;
use App\Models\User;
use App\Models\VoucherCode;
use Illuminate\Http\Request;

class UsageHistoryController extends Controller
{
    public function index(Request $request)
    {
        // ambil filter jika ada
        $query = UsageHistory::with(['user','voucher'])
                    ->orderBy('start_time', 'desc');

        if ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('start_time', '<=', $request->end_date);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('voucher_id')) {
            $query->where('voucher_id', $request->voucher_id);
        }

        $histories = $query->paginate(15)
                           ->appends($request->only(['start_date','end_date','user_id','voucher_id']));

        // data dropdown filter
        $users    = User::orderBy('name')->get();
        $vouchers = VoucherCode::orderBy('code')->get();

        return view('admin.history', compact('histories','users','vouchers'));
    }
}
