<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Adopsi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'adopsis';
    protected $fillable = ['id_pet', 'vendor', 'id_vendor', 'harga_adopsi', 'status'];

    public function adoptpet() {
        return $this->belongsTo(Pet::class, 'id_pet');
    }

    public function vendorid()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }

    public function transaksi() {
        return $this->hasMany(TransaksiAdopsi::class, 'id_adopt');
    }
}
