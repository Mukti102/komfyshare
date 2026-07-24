<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->constrained('checker_orders')->cascadeOnDelete();
            $table->enum('category', ['original', 'support', 'turnitin', 'revision', 'result']);
            $table->string('original_name');
            $table->string('file_name');
            $table->string('extension');
            $table->string('mime_type');
            $table->bigInteger('file_size');
            $table->string('file_path');
            $table->enum('uploaded_by', ['customer', 'admin']);
            $table->dateTime('uploaded_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_files');
    }
};
