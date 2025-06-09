<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiAdopsi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id_adopsi', 'tgl_transaksi', 'total_transaksi', 'status', 'keterangan', 'user_id', 'vendor_id'];

    public function adopsi() {
        return $this->belongsTo(Adopsi::class, 'id_adopsi');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
