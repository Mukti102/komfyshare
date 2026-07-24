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
            $table->enum('pricing_rule', ['none', 'per_file', 'multiply', 'option'])->default('none')->after('is_required');
            $table->decimal('unit_price', 12, 2)->default(0)->after('pricing_rule');
            $table->boolean('affects_price')->default(false)->after('unit_price');

            if (Schema::hasColumn('checker_questions', 'pricing_key')) {
                $table->dropColumn('pricing_key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('checker_questions', function (Blueprint $table) {
            $table->dropColumn(['pricing_rule', 'unit_price', 'affects_price']);
            $table->string('pricing_key')->nullable()->after('is_required');
        });
    }
};
