<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VoucherCode;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        VoucherCode::create([
            'code'             => 'BASIC1H',
            'duration_minutes' => 60,
            'price'            => 1000,
            'promo_id'         => null,
        ]);
        VoucherCode::create([
            'code'             => 'BASIC3H',
            'duration_minutes' => 180,
            'price'            => 2000,
            'promo_id'         => null,
        ]);
        VoucherCode::create([
            'code'             => 'BASIC8H',
            'duration_minutes' => 480,
            'price'            => 5000,
            'promo_id'         => null,
        ]);
    }
}
