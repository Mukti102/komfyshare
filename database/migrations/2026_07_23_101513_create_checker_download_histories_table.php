<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_download_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->constrained('checker_orders')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('costumers');
            $table->dateTime('downloaded_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_download_histories');
    }
};
