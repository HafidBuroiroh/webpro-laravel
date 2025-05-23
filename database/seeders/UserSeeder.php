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
            'email' => 'admin@petter.co.id',
            'email_verified_at' => now(),
            'password' => Hash::make('AdminPetter99'),
            'alamat' => 'Depok Jawa Barat',
            'no_telp' => '081234567890',
            'level' => 'admin',
            'remember_token' => Str::random(10),
        ]);
    }
}
