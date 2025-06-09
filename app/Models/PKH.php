<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PKH extends Model
{
    use HasFactory;
    protected $table = 'penjualan_kebutuhan_hewan';
    protected $primaryKey = 'id';
    protected $fillable = ['jenis', 'nama', 'harga', 'foto', 'status'];

    public function transaksiPKH() {
        return $this->hasMany(TransaksiPKH::class, 'id_pkh');
    }

    public function cart() {
        return $this->hasMany(Cart::class, 'id_pkh');
    }
}
