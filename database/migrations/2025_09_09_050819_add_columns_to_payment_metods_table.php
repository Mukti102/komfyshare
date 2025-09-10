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
        Schema::table('payment_metods', function (Blueprint $table) {
            $table->string('code');
            $table->enum('category', ['Virtual Account', 'Emoney', 'QRIS', 'Retail', 'Pulsa']);
            $table->string('owner')->nullable()->change();
            $table->string('nomor_rek')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_metods', function (Blueprint $table) {
            $table->dropColumn(['code', 'category']);

            // kembalikan ke not nullable (kalau sebelumnya memang wajib isi)
            $table->string('owner')->nullable(false)->change();
            $table->string('nomor_rek')->nullable(false)->change();
        });
    }
};
