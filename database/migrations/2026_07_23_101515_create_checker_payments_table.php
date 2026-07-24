<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->constrained('checker_orders')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_metods');
            $table->string('transaction_code')->nullable();
            $table->enum('gateway', ['midtrans', 'manual', 'token'])->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('admin_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired', 'refund'])->default('pending');
            $table->json('response')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_payments');
    }
};
