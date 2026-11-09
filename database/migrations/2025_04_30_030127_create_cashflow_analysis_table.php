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
        Schema::create('cashflow_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')
                  ->constrained('voucher_codes')
                  ->cascadeOnDelete();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->dateTime('transaction_date');
            $table->string('payment_method', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflow_analysis');
    }
};
