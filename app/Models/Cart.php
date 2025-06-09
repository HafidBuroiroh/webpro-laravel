<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pkh',
        'qty',
        'id_user',
    ];

    public function pkh()
    {
        return $this->belongsTo(PKH::class, 'id_pkh');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
