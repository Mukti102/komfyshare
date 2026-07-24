<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_package_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_package_id')->constrained('checker_packages')->cascadeOnDelete();
            $table->foreignId('checker_service_id')->constrained('checker_services')->cascadeOnDelete();
            $table->integer('token_cost');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_package_services');
    }
};
