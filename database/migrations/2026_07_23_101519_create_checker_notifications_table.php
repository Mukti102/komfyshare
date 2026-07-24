<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('costumers')->cascadeOnDelete();
            $table->foreignId('checker_order_id')->nullable()->constrained('checker_orders')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->enum('channel', ['system', 'whatsapp'])->default('system');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_notifications');
    }
};
