<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('voucher_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->unsignedInteger('duration_minutes');
            $table->decimal('price', 10, 2);
            $table->foreignId('promo_id')->nullable()->constrained('promotions')->nullOnDelete();
            $table->boolean('is_redeemed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_codes');
    }
};
