<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_question_id')->constrained('checker_questions')->cascadeOnDelete();
            $table->string('label');
            $table->string('value');
            $table->decimal('additional_price', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_question_options');
    }
};
