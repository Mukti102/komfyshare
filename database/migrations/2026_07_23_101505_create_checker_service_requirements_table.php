<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_service_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_service_id')->constrained('checker_services')->cascadeOnDelete();
            $table->string('accepted_extension')->nullable();
            $table->integer('max_file_size')->nullable();
            $table->integer('max_upload')->nullable();
            $table->boolean('allow_multiple')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_service_requirements');
    }
};
