<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\CourierService;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        $couriers = [
            [
                'code' => 'jne',
                'name' => 'JNE',
                'services' => [
                    ['service' => 'REG', 'description' => 'Layanan Reguler'],
                    ['service' => 'YES', 'description' => 'Yakin Esok Sampai'],
                ],
            ],
            [
                'code' => 'tiki',
                'name' => 'TIKI',
                'services' => [
                    ['service' => 'REG', 'description' => 'Regular Service'],
                    ['service' => 'ONS', 'description' => 'Over Night Service'],
                ],
            ],
            [
                'code' => 'pos',
                'name' => 'POS Indonesia',
                'services' => [
                    ['service' => 'Paket Kilat Khusus', 'description' => 'Paket Kilat Khusus'],
                    ['service' => 'Express Next Day', 'description' => 'Express Service'],
                ],
            ],
        ];

        foreach ($couriers as $courierData) {
            $courier = Courier::create([
                'code' => $courierData['code'],
                'name' => $courierData['name'],
            ]);

            foreach ($courierData['services'] as $service) {
                $courier->services()->create($service);
            }
        }
    }
}
