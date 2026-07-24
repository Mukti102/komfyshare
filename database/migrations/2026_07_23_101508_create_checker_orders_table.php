<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('costumers');
            $table->foreignId('checker_service_id')->constrained('checker_services');
            $table->foreignId('checker_package_id')->nullable()->constrained('checker_packages');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_metods');
            $table->enum('payment_type', ['token', 'midtrans']);
            $table->decimal('total_price', 10, 2);
            $table->integer('token_used')->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'waiting_payment', 'paid', 'queued', 'assigned', 'processing', 'review', 'completed', 'cancelled', 'expired'])->default('draft');
            $table->dateTime('estimated_finish')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_orders');
    }
};
