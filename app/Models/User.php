<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'no_telp',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vendor() {
        return $this->hasMany(Vendor::class, 'id_user');
    }

    public function transaksiAdopsi() {
        return $this->hasMany(TransaksiAdopsi::class, 'user_id');
    }

    public function transaksiPenjualanPet() {
        return $this->hasMany(TransaksiPenjualanPet::class, 'user_id');
    }

    public function transaksiPKH() {
        return $this->hasMany(TransaksiPKH::class, 'user_id');
    }

    public function pengiriman() {
        return $this->hasMany(Pengiriman::class, 'id_user');
    }

    public function cart() {
        return $this->hasMany(Pengiriman::class, 'id_user');
    }
    public function detailaddress() {
        return $this->hasMany(DetailAddress::class, 'id_user');
    }
}
