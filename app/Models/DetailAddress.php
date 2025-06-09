<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailAddress extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'address', 'province_id', 'district_id', 'village_id', 'post_code', 'latitude', 'longitude'];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
