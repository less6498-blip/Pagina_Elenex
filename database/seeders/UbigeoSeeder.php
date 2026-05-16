<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbigeoSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // DEPARTAMENTOS
        // ======================
        DB::table('departments')->insert([
            ['id' => 1, 'name' => 'Lima'],
            ['id' => 2, 'name' => 'Cusco'],
        ]);

        // ======================
        // PROVINCIAS
        // ======================
        DB::table('provinces')->insert([
            // Lima
            ['id' => 1, 'name' => 'Lima', 'department_id' => 1],
            ['id' => 2, 'name' => 'Barranca', 'department_id' => 1],

            // Cusco
            ['id' => 3, 'name' => 'Cusco', 'department_id' => 2],
            ['id' => 4, 'name' => 'Urubamba', 'department_id' => 2],
        ]);

        // ======================
        // DISTRITOS
        // ======================
        DB::table('districts')->insert([
            // Lima (provincia 1)
            ['id' => 1, 'name' => 'Miraflores', 'province_id' => 1],
            ['id' => 2, 'name' => 'San Isidro', 'province_id' => 1],
            ['id' => 3, 'name' => 'Surco', 'province_id' => 1],

            // Barranca (provincia 2)
            ['id' => 4, 'name' => 'Barranca', 'province_id' => 2],

            // Cusco (provincia 3)
            ['id' => 5, 'name' => 'Cusco', 'province_id' => 3],
            ['id' => 6, 'name' => 'Santiago', 'province_id' => 3],

            // Urubamba (provincia 4)
            ['id' => 7, 'name' => 'Urubamba', 'province_id' => 4],
        ]);
    }
}