<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashflowAnalysis extends Model
{
    use HasFactory;

    protected $table = 'cashflow_analysis';

    protected $fillable = [
        'voucher_id', 'user_id',
        'amount', 'transaction_date', 'payment_method',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount'           => 'decimal:2',
    ];

    public function voucher()
    {
        return $this->belongsTo(VoucherCode::class, 'voucher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cashflowAnalysis()
    {
        return $this->hasOne(CashflowAnalysis::class, 'voucher_id', 'id');
    }
}
