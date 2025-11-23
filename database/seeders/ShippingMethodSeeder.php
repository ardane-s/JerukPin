<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingMethods = [
            [
                'name' => 'Own Driver (COD)',
                'code' => 'own_driver',
                'description' => 'Diantar langsung oleh driver JerukPin. Bayar di tempat.',
                'base_cost' => 10000,
                'icon' => '🚗',
                'estimated_days' => 0,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'JNT Express',
                'code' => 'jnt',
                'description' => 'J&T Express - Pengiriman cepat dan terpercaya',
                'base_cost' => 12000,
                'icon' => '📦',
                'estimated_days' => 2,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'GOJEK (GoSend)',
                'code' => 'gojek',
                'description' => 'Diantar ojek online dalam 1 hari',
                'base_cost' => 15000,
                'icon' => '🏍️',
                'estimated_days' => 0,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Grab Express',
                'code' => 'grab',
                'description' => 'Pengiriman instant via Grab',
                'base_cost' => 16000,
                'icon' => '🚕',
                'estimated_days' => 0,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'ShopeeExpress',
                'code' => 'shopee',
                'description' => 'Layanan pengiriman Shopee',
                'base_cost' => 11000,
                'icon' => '🛒',
                'estimated_days' => 3,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'SiCepat',
                'code' => 'sicepat',
                'description' => 'SiCepat - Cepat dan Handal',
                'base_cost' => 12000,
                'icon' => '⚡',
                'estimated_days' => 2,
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'JNE',
                'code' => 'jne',
                'description' => 'Jalur Nugraha Ekakurir - Terpercaya',
                'base_cost' => 13000,
                'icon' => '📮',
                'estimated_days' => 3,
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'TIKI',
                'code' => 'tiki',
                'description' => 'Titipan Kilat - Pengiriman Express',
                'base_cost' => 14000,
                'icon' => '📬',
                'estimated_days' => 2,
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($shippingMethods as $method) {
            ShippingMethod::create($method);
        }
    }
}
