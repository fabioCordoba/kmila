<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'uid' => 1067955067,
            'phone' => 31065552199,
            'address' => 'mz B lote 17 etapa 1 B/los nogales',
            'name' => 'Camila correa',
            'email' => 'camilacorrea@gmail.com',
            'password' => Hash::make('admin'),
            'status' => 'Active'
        ]);

        $admin->assignRole('ADMIN');

        $admin = User::create([
            'uid' => 1067955068,
            'phone' => 31065552199,
            'address' => 'mz B lote 17 etapa 1 B/los nogales',
            'name' => 'Fabio Cordoba',
            'email' => 'fabiocordoba1@gmail.com',
            'password' => Hash::make('admin'),
            'status' => 'Active'
        ]);

        $admin->assignRole('ROOT');

        $asesor = User::create([
            'uid' => 1067955069,
            'phone' => 31065552199,
            'address' => 'mz B lote 17 etapa 1 B/los nogales',
            'name' => 'Cliente',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('cliente'),
            'status' => 'Active'
        ]);

        $asesor->assignRole('USER');
    }
}
