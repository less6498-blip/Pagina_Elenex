<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Polos', 'descripcion' => 'Polos modernos', 'slug' => 'polos'],
            ['nombre' => 'Casacas', 'descripcion' => 'Casacas urbanas', 'slug' => 'casacas'],
            ['nombre' => 'Bividis', 'descripcion' => 'Bividis cómodos y de moda', 'slug' => 'bividis'],
            ['nombre' => 'Camisas', 'descripcion' => 'Camisas de hombre y mujer', 'slug' => 'camisas'],
            ['nombre' => 'Chalecos', 'descripcion' => 'Chalecos modernos', 'slug' => 'chalecos'],
            ['nombre' => 'Poleras', 'descripcion' => 'Poleras clásicas y urbanas', 'slug' => 'poleras'],
            ['nombre' => 'Pantalones', 'descripcion' => 'Pantalones casuales y formales', 'slug' => 'pantalones'],
            ['nombre' => 'Joggers', 'descripcion' => 'Joggers cómodos', 'slug' => 'joggers'],
            ['nombre' => 'Bermudas', 'descripcion' => 'Bermudas para verano', 'slug' => 'bermudas'],
            ['nombre' => 'Shorts', 'descripcion' => 'Shorts casuales', 'slug' => 'shorts'],
            ['nombre' => 'Calzados', 'descripcion' => 'Lo mejor en calzados', 'slug' => 'calzados'],
            ['nombre' => 'Accesorios', 'descripcion' => 'Complementos y accesorios de moda', 'slug' => 'accesorios'],
        ];

        foreach ($categorias as $cat) {
            Categoria::firstOrCreate(
                ['slug' => $cat['slug']], // ⚡ Usa slug como clave única
                ['nombre' => $cat['nombre'], 'descripcion' => $cat['descripcion']]
            );
        }
    }
}