<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_toko');
            $table->text('deskripsi_toko');
            $table->string('alamat_toko');
            $table->enum('status_toko', ['aktif', 'nonaktif']);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('pets', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_pet');
            $table->string('jenis');
            $table->string('ras');
            $table->integer('umur');
            $table->string('foto');
            $table->enum('status', ['adopsi', 'dijual']);
            $table->timestamps();
        });

        Schema::create('adopsis', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_pet');
            $table->boolean('vendor');
            $table->unsignedBigInteger('id_vendor')->nullable();
            $table->decimal('harga_adopsi', 12, 2);
            $table->enum('status', ['tersedia', 'diadopsi']);
            $table->timestamps();

            $table->foreign('id_pet')->references('id')->on('pets')->onDelete('cascade');
            $table->foreign('id_vendor')->references('id')->on('vendors')->onDelete('cascade');
        });

        Schema::create('penjualan_pets', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_pet');
            $table->decimal('harga', 12, 2);
            $table->enum('status', ['tersedia', 'dikirim', 'terjual']);
            $table->timestamps();

            $table->foreign('id_pet')->references('id')->on('pets')->onDelete('cascade');
        });

        Schema::create('penjualan_kebutuhan_hewan', function (Blueprint $table) {
            $table->id('id');
            $table->enum('jenis', ['pakan hewan', 'kandang', 'kebutuhan lainnya']);
            $table->string('nama');
            $table->decimal('harga', 12, 2);
            $table->string('foto');
            $table->integer('stock');
            $table->enum('status', ['tersedia', 'dikirim', 'terjual']);
            $table->timestamps();
        });

        Schema::create('transaksi_adopsis', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_adopt');
            $table->date('tgl_transaksi');
            $table->decimal('total_transaksi', 12, 2);
            $table->enum('status', ['menunggu', 'berhasil', 'dibatalkan']);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->timestamps();

            $table->foreign('id_adopt')->references('id')->on('adopsis')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });

        Schema::create('transaksi_penjualan_pets', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_penjualan');
            $table->date('tgl_transaksi');
            $table->decimal('total_transaksi', 12, 2);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id')->on('penjualan_pets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('transaksi_pkh', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->unsignedBigInteger('id_pkh');
            $table->date('tgl_transaksi');
            $table->decimal('total_transaksi', 12, 2);
            $table->integer('qty');
            $table->enum('status', ['dikemas', 'dikirim', 'berhasil', 'dibatalkan']);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('id_pkh')->references('id')->on('penjualan_kebutuhan_hewan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_transaksi_pkh');
            $table->enum('kurir', ['jnt', 'jne', 'grab/gosend']);
            $table->decimal('biaya_ongkir', 12, 2);
            $table->enum('pembayaran', ['cod', 'transfer']);
            $table->decimal('total_biaya', 12, 2);
            $table->enum('status', ['diperjalanan', 'selesai', 'diretur']);
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_transaksi_pkh')->references('id')->on('transaksi_pkh')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
        Schema::dropIfExists('transaksi_pkh');
        Schema::dropIfExists('transaksi_penjualan_pets');
        Schema::dropIfExists('transaksi_adopsis');
        Schema::dropIfExists('penjualan_kebutuhan_hewan');
        Schema::dropIfExists('penjualan_pets');
        Schema::dropIfExists('adopsis');
        Schema::dropIfExists('pets');
        Schema::dropIfExists('vendors');
    }
};
