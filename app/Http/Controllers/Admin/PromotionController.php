<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        // kirim semua promo terbaru ke view
        $promotions = Promotion::orderBy('start_date', 'desc')->get();
        return view('admin.promotions', compact('promotions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'type'         => 'required|in:discount,free_voucher',
            'value'        => 'required|numeric|min:0',
            'min_quantity' => 'required|integer|min:1',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);

        Promotion::create($data);

        return redirect()->route('admin.promotions')
                         ->with('success', 'Promosi berhasil ditambahkan.');
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'type'         => 'required|in:discount,free_voucher',
            'value'        => 'required|numeric|min:0',
            'min_quantity' => 'required|integer|min:1',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);

        $promotion->update($data);

        return redirect()->route('admin.promotions')
                         ->with('success', 'Promosi berhasil diperbarui.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions')
                         ->with('success', 'Promosi berhasil dihapus.');
    }
}
