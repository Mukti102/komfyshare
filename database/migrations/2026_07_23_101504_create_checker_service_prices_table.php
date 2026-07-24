<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_service_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_service_id')->constrained('checker_services')->cascadeOnDelete();
            $table->enum('pricing_type', ['fixed', 'per_page', 'per_word', 'express']);
            $table->decimal('minimum_price', 10, 2)->default(0);
            $table->decimal('maximum_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_service_prices');
    }
};
