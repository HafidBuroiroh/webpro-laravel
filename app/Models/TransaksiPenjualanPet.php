<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiPenjualanPet extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function penjualanPet() {
        return $this->belongsTo(PenjualanPet::class, 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
