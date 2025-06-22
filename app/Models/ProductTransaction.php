<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke TransaksiPKH
    public function transaksi()
    {
        return $this->belongsTo(TransaksiPKH::class, 'transaksi_pkh_id');
    }

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(PKH::class, 'id_pkh');
    }

}
