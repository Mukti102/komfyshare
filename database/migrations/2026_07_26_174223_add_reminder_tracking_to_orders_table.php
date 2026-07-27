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
            $table->boolean('reminder_h2_sent')->default(false)->after('status');
            $table->boolean('reminder_h0_sent')->default(false)->after('reminder_h2_sent');
            $table->boolean('milestone_m2_sent')->default(false)->after('reminder_h0_sent');
            $table->boolean('milestone_m3_sent')->default(false)->after('milestone_m2_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_h2_sent',
                'reminder_h0_sent',
                'milestone_m2_sent',
                'milestone_m3_sent'
            ]);
        });
    }
};
