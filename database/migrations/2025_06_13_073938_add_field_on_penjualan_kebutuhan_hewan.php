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
         Schema::table('penjualan_kebutuhan_hewan', function (Blueprint $table) {
            $table->integer('weight')->nullable();
        });
         Schema::table('transaksi_penjualan_pets', function (Blueprint $table) {
            $table->integer('total_weight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
