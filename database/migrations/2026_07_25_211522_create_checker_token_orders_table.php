<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checker_token_orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('costumers')->cascadeOnDelete();
            $table->foreignId('checker_package_id')->constrained('checker_packages');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_metods');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['waiting_payment', 'paid', 'cancelled'])->default('waiting_payment');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checker_token_orders');
    }
};
