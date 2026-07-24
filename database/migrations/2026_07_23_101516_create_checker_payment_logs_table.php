<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_payment_id')->constrained('checker_payments')->cascadeOnDelete();
            $table->string('status');
            $table->text('gateway_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_payment_logs');
    }
};
