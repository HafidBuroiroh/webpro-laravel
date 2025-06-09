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
        Schema::table('pets', function (Blueprint $table) {
            $table->text('deskripsi')->nullable();
        });
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->string('shipping_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['deskripsi']);
        });
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->dropColumn(['shipping_method']);
        });
    }
};
