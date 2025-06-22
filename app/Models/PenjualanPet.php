<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanPet extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'penjualan_pets';
    protected $fillable = ['id_pet', 'harga', 'status'];

    public function jualpet() {
        return $this->belongsTo(Pet::class, 'id_pet');
    }

    public function transaksi() {
        return $this->hasMany(TransaksiPenjualanPet::class, 'id_penjualan');
    }
}
