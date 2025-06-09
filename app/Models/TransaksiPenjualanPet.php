<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiPenjualanPet extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id_penjualan', 'tgl_transaksi', 'total_transaksi', 'keterangan', 'user_id'];

    public function penjualanPet() {
        return $this->belongsTo(PenjualanPet::class, 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
