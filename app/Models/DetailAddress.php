<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailAddress extends Model
{
    use HasFactory;
    protected $table = 'detail_address';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
