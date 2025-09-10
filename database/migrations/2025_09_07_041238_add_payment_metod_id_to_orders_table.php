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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_metod_id')) {
                $table->unsignedBigInteger('payment_metod_id')->nullable();
                $table->foreign('payment_metod_id')
                      ->references('id')
                      ->on('payment_metods')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_metod_id')) {
                $table->dropForeign(['payment_metod_id']);
                $table->dropColumn('payment_metod_id');
            }
        });
    }
};
