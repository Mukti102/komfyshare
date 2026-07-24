<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->constrained('checker_orders')->cascadeOnDelete();
            $table->foreignId('admin_user_id')->constrained('users');
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('accepted_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->enum('status', ['assigned', 'accepted', 'completed'])->default('assigned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_assignments');
    }
};
