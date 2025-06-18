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
        Schema::create('detail_address', function (Blueprint $table) {
            $table->id();
            $table->longText('address');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('province_code');
            $table->unsignedBigInteger('district_code');
            $table->unsignedBigInteger('city_code');
            $table->unsignedBigInteger('village_code')->nullable();
            $table->longText('post_code')->nullable();
            $table->longText('latitude')->nullable();
            $table->longText('longitude')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_detail_address');
    }
};
