<?php

namespace Database\Seeders;

use App\Models\FpgaComponent;
use App\Models\Manufacturer;
use App\Models\Role;
use App\Models\Standard;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Роли
        $roles = [
            ['name' => 'admin'],
            ['name' => 'user']
        ];
        foreach ($roles as $data) {
            Role::create($data);
        }

        // Пользователи
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2
            ]
        ];
        foreach ($users as $data) {
            User::create($data);
        }

        // Производители
        $manufacturers = [
            ['name' => 'Xilinx', 'country' => 'USA'],
            ['name' => 'Intel', 'country' => 'USA'],
            ['name' => 'ОАО Интеграл', 'country' => 'Беларусь'],
            ['name' => 'НПП Микроэлектроника', 'country' => 'Россия']
        ];
        foreach ($manufacturers as $data) {
            Manufacturer::create($data);
        }

        // Компоненты ИСПЛ
        $components = [
            [
                'manufacturer_id' => 1,
                'model' => 'Spartan-7 XC7S15',
                'frequency' => 200,
                'lut_count' => 12800,
                'power' => 4.0,
                'io_count' => 100,
                'cost' => 50.00,
                'availability' => 'in_stock'
            ],
            [
                'manufacturer_id' => 2,
                'model' => 'Cyclone IV EP4CE10',
                'frequency' => 150,
                'lut_count' => 10320,
                'power' => 3.5,
                'io_count' => 80,
                'cost' => 40.00,
                'availability' => 'in_stock'
            ],
            [
                'manufacturer_id' => 3,
                'model' => '5588ХС',
                'frequency' => 180,
                'lut_count' => 8000,
                'power' => 4.5,
                'io_count' => 90,
                'cost' => 60.00,
                'availability' => 'on_order'
            ]
        ];
        foreach ($components as $data) {
            FpgaComponent::create($data);
        }

        // Стандарты
        $standards = [
            ['name' => 'DDR3'],
            ['name' => 'SPI'],
            ['name' => 'PCIe'],
            ['name' => 'I2C']
        ];
        foreach ($standards as $data) {
            Standard::create($data);
        }

        // Связь ИСПЛ и стандартов
        FpgaComponent::find(1)->standards()->attach([1, 2]); // Spartan-7: DDR3, SPI
        FpgaComponent::find(2)->standards()->attach(4); // Cyclone IV: I2C
        FpgaComponent::find(3)->standards()->attach(2); // 5588ХС: SPI
    }
}
