<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->nullable()->constrained('checker_orders')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('costumers')->cascadeOnDelete();
            $table->string('phone');
            $table->text('message');
            $table->string('provider')->nullable();
            $table->text('response')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_whatsapp_logs');
    }
};
