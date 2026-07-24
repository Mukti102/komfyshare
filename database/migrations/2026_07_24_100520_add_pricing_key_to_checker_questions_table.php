<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('checker_questions', function (Blueprint $table) {
            $table->string('pricing_key')->nullable()->after('is_required');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checker_questions', function (Blueprint $table) {
            $table->dropColumn('pricing_key');
        });
    }
};
