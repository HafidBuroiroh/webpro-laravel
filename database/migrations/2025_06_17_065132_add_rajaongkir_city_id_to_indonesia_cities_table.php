<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('indonesia_cities', function (Blueprint $table) {
            $table->integer('rajaongkir_city_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('indonesia_cities', function (Blueprint $table) {
            $table->dropColumn('rajaongkir_city_id');
        });
    }
};
