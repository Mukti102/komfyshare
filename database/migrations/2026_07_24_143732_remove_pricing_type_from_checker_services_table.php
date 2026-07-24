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
        Schema::table('checker_services', function (Blueprint $table) {
            $table->dropColumn('pricing_type');
        });
    }

    public function down(): void
    {
        Schema::table('checker_services', function (Blueprint $table) {
            $table->enum('pricing_type', ['fixed', 'per_file', 'per_page', 'option_sum'])->default('fixed')->after('is_token_available');
        });
    }
};
