<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'pets';
    protected $fillable = ['nama_pet', 'jenis', 'ras', 'umur', 'foto', 'status'];

    public function adopsi() {
        return $this->hasMany(Adopsi::class, 'id_pet');
    }
    public function penjualan() {
        return $this->hasMany(PenjualanPet::class, 'id_pet');
    }
}
