<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Petter',
            'email' => 'It@petter.co.id',
            'email_verified_at' => now(),
            'password' => Hash::make('ItPetter99'),
            'alamat' => 'Depok Jawa Barat',
            'no_telp' => '081234567890',
            'level' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Vendor Petter',
            'email' => 'Vendor@petter.co.id',
            'email_verified_at' => now(),
            'password' => Hash::make('VendorPetter99'),
            'alamat' => 'SCBD, Tanggerang',
            'no_telp' => '081234567890',
            'level' => 'vendor',
            'remember_token' => Str::random(10),
        ]);
    }
}
