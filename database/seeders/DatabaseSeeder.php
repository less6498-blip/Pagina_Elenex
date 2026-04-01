<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      
    // Aquí llamamos a tu seeder de categorias
        $this->call(CategoriaSeeder::class);

    // Aquí llamamos a tu seeder de productos
        $this->call(ProductoSeeder::class);
    }
}
