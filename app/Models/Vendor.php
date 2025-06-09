<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'nama_toko', 'deskripsi_toko', 'alamat_toko', 'status_toko'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function adopsi() {
        return $this->hasMany(Adopsi::class, 'id_vendor');
    }
    public function transaksi() {
        return $this->hasMany(TransaksiAdopsi::class, 'vendor_id');
    }
}
