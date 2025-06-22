<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_pkh_id');
            $table->unsignedBigInteger('id_pkh');
            $table->integer('qty');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->foreign('transaksi_pkh_id')->references('id')->on('transaksi_pkh')->onDelete('cascade');
            $table->foreign('id_pkh')->references('id')->on('penjualan_kebutuhan_hewan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
