<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiPKH extends Model
{
    use HasFactory;
    protected $table = 'transaksi_pkh';
    protected $primaryKey = 'id';
    protected $fillable = ['id_pkh', 'tgl_transaksi', 'total_transaksi', 'status', 'user_id'];

    public function pkh() {
        return $this->belongsTo(PKH::class, 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

    public function pengiriman() {
        return $this->hasMany(Pengiriman::class, 'id_transaksi_pkh');
    }
}
