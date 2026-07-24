<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checker_order_id')->constrained('checker_orders')->cascadeOnDelete();
            $table->foreignId('checker_question_id')->constrained('checker_questions');
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_answers');
    }
};
