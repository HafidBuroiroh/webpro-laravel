<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'pengirimans';

    protected $guarded = [];

    public function transaksiPKH()
    {
        return $this->belongsTo(TransaksiPKH::class, 'id_transaksi_pkh');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
