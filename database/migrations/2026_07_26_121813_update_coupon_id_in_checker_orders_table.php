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
        Schema::table('checker_orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn('coupon_id');
            $table->foreignId('checker_coupon_id')->nullable()->after('payment_method_id')->constrained('checker_coupons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checker_orders', function (Blueprint $table) {
            $table->dropForeign(['checker_coupon_id']);
            $table->dropColumn('checker_coupon_id');
            $table->foreignId('coupon_id')->nullable()->after('payment_method_id')->constrained('coupons');
        });
    }
};
