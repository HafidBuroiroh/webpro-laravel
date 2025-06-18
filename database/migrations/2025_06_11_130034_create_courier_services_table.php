<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courier_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->string('service'); // contoh: REG, OKE, YES
            $table->string('description'); // contoh: Regular Service, Ongkos Kirim Ekonomis
            $table->timestamps();


            
            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courier_services');
    }
};
