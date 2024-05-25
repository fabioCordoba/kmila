<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Capital;

class CapitalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Capital::create([
            'amount' => 500000,
            'with_partner' => false,
            'description' => 'Ingreso capital 1',
            'type' => 'in',
            'status' => 'Active'
        ]);

        Capital::create([
            'amount' => 200000,
            'with_partner' => false,
            'description' => 'Ingreso capital 2',
            'type' => 'in',
            'status' => 'Active'
        ]);

        Capital::create([
            'amount' => 500000,
            'with_partner' => false,
            'description' => 'Ingreso capital 3',
            'type' => 'in',
            'status' => 'Active'
        ]);

    }
}
