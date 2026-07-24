<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_service_id')->constrained('checker_services')->cascadeOnDelete();
            $table->string('label');
            $table->string('field_name');
            $table->string('validation')->nullable();
            $table->text('help_text')->nullable();
            $table->enum('field_type', ['text', 'textarea', 'number', 'checkbox', 'radio', 'select', 'file']);
            $table->string('placeholder')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_questions');
    }
};
