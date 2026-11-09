<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'value', 'min_quantity', 'start_date', 'end_date'
    ];

    // Cast tanggal jadi Carbon instance
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function vouchers()
    {
        return $this->hasMany(VoucherCode::class, 'promo_id');
    }
}


