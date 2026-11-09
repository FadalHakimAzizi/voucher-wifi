<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voucher_codes', function (Blueprint $table) {
            $table->timestamp('redeemed_at')->nullable()->after('is_redeemed');
        });
    }

    public function down(): void
    {
        Schema::table('voucher_codes', function (Blueprint $table) {
            $table->dropColumn('redeemed_at');
        });
    }
};