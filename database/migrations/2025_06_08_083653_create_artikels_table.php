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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('subjudul');
            $table->longText('isi');
            $table->string('slug');
            $table->string('sampul');
            $table->timestamps();
        });

        Schema::table('pets', function (Blueprint $table) {
            $table->text('slug');
        });

        Schema::table('penjualan_kebutuhan_hewan', function (Blueprint $table) {
            $table->text('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['slug']);
        });
        Schema::table('penjualan_kebutuhan_hewan', function (Blueprint $table) {
            $table->dropColumn(['slug']);
        });
    }
};
