<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_token_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_token_wallet_id')->constrained('checker_token_wallets')->cascadeOnDelete();
            $table->foreignId('checker_order_id')->nullable()->constrained('checker_orders');
            $table->foreignId('checker_package_id')->nullable()->constrained('checker_packages');
            $table->enum('type', ['purchase', 'usage', 'refund', 'bonus']);
            $table->integer('token');
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_token_histories');
    }
};
