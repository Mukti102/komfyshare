<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checker_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->boolean('is_token_available')->default(false);
            $table->enum('pricing_type', ['fixed', 'per_file', 'per_page', 'option_sum'])->default('fixed');
            $table->decimal('base_price', 10, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('color')->nullable();
            $table->string('badge')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checker_services');
    }
};
