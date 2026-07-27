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
        Schema::table('checker_token_wallets', function (Blueprint $table) {
            $table->foreignId('checker_package_id')->after('customer_id')->nullable()->constrained('checker_packages')->cascadeOnDelete();
            $table->dateTime('expired_at')->after('total_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checker_token_wallets', function (Blueprint $table) {
            $table->dropForeign(['checker_package_id']);
            $table->dropColumn('checker_package_id');
            $table->dropColumn('expired_at');
        });
    }
};
