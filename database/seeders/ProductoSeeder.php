<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Marca;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // ===========================
        // 1️⃣ Crear la Marca
        // ===========================
        $marca = Marca::firstOrCreate(
            ['nombre' => 'Elenex'], // condición para no duplicar
            ['activo' => 1]
        );

        // ===========================
        // 2️⃣ Crear Categorías
        // ===========================
        $polos = Categoria::firstOrCreate([
            'nombre' => 'Polos'
        ], [
            'descripcion' => 'Polos de hombre y mujer',
            'slug' => 'polos'
        ]);

        $casacas = Categoria::firstOrCreate([
            'nombre' => 'Casacas'
        ], [
            'descripcion' => 'Casacas para todas las temporadas',
            'slug' => 'casacas'
        ]);

        // ===========================
        // 3️⃣ Crear Productos Polos
        // ===========================
        $productosPolos = [
            [
                'nombre' => 'Polo Mojito',
                'talla' => 'M',
                'color' => 'Blanco',
                'stock' => 10,
                'imagen' => 'mojito1.png',
                'imagen2' => 'mojito2.png',
                'slug' => 'polo-mojito',
                'precio' => 65.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Polo Oversize Negro',
                'talla' => 'L',
                'color' => 'Negro',
                'stock' => 8,
                'imagen' => 'over1.png',
                'imagen2' => 'over2.png',
                'slug' => 'polo-oversize-negro',
                'precio' => 65.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Polo Oversize Verde',
                'talla' => 'M',
                'color' => 'Verde',
                'stock' => 7,
                'imagen' => 'oververde1.png',
                'imagen2' => 'oververde2.png',
                'slug' => 'polo-oversize-verde',
                'precio' => 65.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Bividi Blanco',
                'talla' => 'M',
                'color' => 'Blanco',
                'stock' => 5,
                'imagen' => 'bividi1.png',
                'imagen2' => 'bividi2.png',
                'slug' => 'bividi-blanco',
                'precio' => 65.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Polo Wait Azul',
                'talla' => 'M',
                'color' => 'Azul',
                'stock' => 5,
                'imagen' => 'wait1.png',
                'imagen2' => 'wait2.png',
                'slug' => 'wait-azul',
                'precio' => 65.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Polo Nomadic Blanco',
                'talla' => 'S',
                'color' => 'Blanco',
                'stock' => 5,
                'imagen' => 'nomadic1.png',
                'imagen2' => 'nomadic2.png',
                'slug' => 'nomadic-blanco',
                'precio' => 65.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Polo Stop Wars',
                'talla' => 'M',
                'color' => 'Cocoa',
                'stock' => 5,
                'imagen' => 'stopwars1.png',
                'imagen2' => 'stopwars2.png',
                'slug' => 'stopwars-cocoa',
                'precio' => 65.00,
                'activo' => 1
            ],
        ];

        foreach ($productosPolos as $producto) {
            Producto::create(array_merge($producto, [
                'categoria_id' => $polos->id,
                'marca_id' => $marca->id
            ]));
        }

        // ===========================
        // 4️⃣ Crear Productos Casacas
        // ===========================
        $productosCasacas = [
            [
                'nombre' => 'Casaca Wheeler Negro',
                'talla' => 'M',
                'color' => 'Negro',
                'stock' => 4,
                'imagen' => 'wheeler.png',
                'imagen2' => 'wheeler2.png',
                'slug' => 'casaca-wheeler-negro',
                'precio' => 124.00,
                'activo' => 1
            ],
            [
                'nombre' => 'Casaca Trek Verde',
                'talla' => 'L',
                'color' => 'Verde',
                'stock' => 6,
                'imagen' => 'trek.png',
                'imagen2' => 'trek2.png',
                'slug' => 'casaca-trek-verde',
                'precio' => 299.90,
                'activo' => 1
            ],
            [
                'nombre' => 'Casaca Quik negro',
                'talla' => 'M',
                'color' => 'Negro',
                'stock' => 11,
                'imagen' => 'quik.png',
                'imagen2' => 'quik2.png',
                'slug' => 'casaca-quik-negro',
                'precio' => 369.90,
                'activo' => 1
            ],
            [
                'nombre' => 'Casaca Carnero Lond',
                'talla' => 'S',
                'color' => 'Negro',
                'stock' => 14,
                'imagen' => 'carnero.png',
                'imagen2' => 'carnero2.png',
                'slug' => 'casaca-carnero-lond-negro',
                'precio' => 219.90,
                'activo' => 1
            ],
            [
                'nombre' => 'Casaca Counter Verde',
                'talla' => 'M',
                'color' => 'Verde',
                'stock' => 9,
                'imagen' => 'counter.png',
                'imagen2' => 'counter2.png',
                'slug' => 'casaca-counter-verde',
                'precio' => 219.90,
                'activo' => 1
            ],
            [
                'nombre' => 'Casaca Carnero Lond',
                'talla' => 'M',
                'color' => 'Beige',
                'stock' => 20,
                'imagen' => 'carn.png',
                'imagen2' => 'carn2.png',
                'slug' => 'casaca-carnero-lond-beige',
                'precio' => 249.90,
                'activo' => 1
            ],
            [
                'nombre' => 'Casaca Boxy Fit Nomad',
                'talla' => 'L',
                'color' => 'Violeta',
                'stock' => 6,
                'imagen' => 'boxy.png',
                'imagen2' => 'boxy2.png',
                'slug' => 'casaca-boxy-fit-nomad',
                'precio' => 249.90,
                'activo' => 1
            ],
        ];

        foreach ($productosCasacas as $producto) {
            Producto::create(array_merge($producto, [
                'categoria_id' => $casacas->id,
                'marca_id' => $marca->id
            ]));
        }

    }
}