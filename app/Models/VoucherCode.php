<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VoucherCode extends Model
{
    use HasFactory;

    protected $appends = ['valid_until'];

    protected $fillable = [
        'code', 'duration_minutes', 'price', 'promo_id', 'is_redeemed', 'redeemed_at', 'expires_at',
    ];

    protected $dates = ['expires_at'];

    protected $casts = [
        'is_redeemed' => 'boolean',
        'redeemed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function promo() {
        return $this->belongsTo(Promotion::class, 'promo_id');
    }

    public function getValidUntilAttribute(): ?Carbon
    {
        if (! $this->created_at || ! $this->duration_minutes) {
            return null;
        }
        return $this->created_at->copy()->addMinutes($this->duration_minutes);
    }
    
    public function cashflowAnalysis()
{
    return $this->hasOne(CashflowAnalysis::class, 'voucher_id');
}

public function cashflowAnalyses()
    {
        return $this->hasMany(CashflowAnalysis::class, 'voucher_id');
    }

public function usageHistory()
{
    return $this->hasOne(UsageHistory::class, 'voucher_id');
}

public function creator()
{
    return $this->belongsTo(User::class, 'creator_id');
}
}
