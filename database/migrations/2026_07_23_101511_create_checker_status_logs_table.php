<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->constrained('checker_orders')->cascadeOnDelete();
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('changed_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_status_logs');
    }
};
