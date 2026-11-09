<?php

namespace App\Console\Commands;

use App\Models\UsageHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateUsageHistoryExpiration extends Command
{
    protected $signature = 'usage-history:update-expiration';
    protected $description = 'Update expires_at for existing usage_history records';

    public function handle()
    {
        $histories = UsageHistory::whereNull('expires_at')->with('voucher')->get();

        foreach ($histories as $history) {
            if ($history->voucher && $history->redeemed_at) {
                $history->expires_at = Carbon::parse($history->redeemed_at)
                    ->addMinutes($history->voucher->duration_minutes);
                $history->save();
                $this->info("Updated expires_at for usage_history ID: {$history->id}");
            }
        }

        $this->info('Finished updating usage history expiration dates.');
    }
}

