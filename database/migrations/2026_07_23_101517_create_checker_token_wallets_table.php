<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_token_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('costumers')->cascadeOnDelete();
            $table->integer('total_token')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_token_wallets');
    }
};
