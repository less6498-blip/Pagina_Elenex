<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Variante;
use App\Models\Imagen;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $marca = Marca::firstOrCreate(['nombre' => 'Elenex'], ['activo' => 1]);

        $polos = Categoria::where('slug', 'polos')->first();
        $casacas = Categoria::where('slug', 'casacas')->first();
        $bividis = Categoria::where('slug', 'bividis')->first();

        // ===========================
        // Productos Polos (New Arrivals)
        // ===========================
        $productosPolos = [
            [
                'nombre' => 'Polo Mojito Oversize',
                'precio' => 75.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Blanco','tallas'=>['S'=>20,'M'=>30,'L'=>30,'XL'=>15],'imagenes'=>['mojito1.webp','mojito2.webp']],
                ]
            ],
            [
                'nombre' => 'Polo Harry Oversize',
                'precio' => 75.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Negro','tallas'=>['S'=>15,'M'=>15,'L'=>13,'XL'=>0],'imagenes'=>['over1.webp','over2.webp']],
                ]
            ],
            [
                'nombre' => 'Polo Positive Oversize',
                'precio' => 65.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Oliva','tallas'=>['S'=>21,'M'=>20,'L'=>10,'XL'=>5],'imagenes'=>['oververde1.webp','oververde2.webp']],
                ]
            ],
            [
                'nombre' => 'Polo Wait Boxy',
                'precio' => 65.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Acero','tallas'=>['S'=>29,'M'=>23,'L'=>12,'XL'=>10],'imagenes'=>['wait1.webp','wait2.webp']],
                ]
            ],
            [
                'nombre' => 'Polo Nomadic Boxy',
                'precio' => 65.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Blanco','tallas'=>['S'=>3,'M'=>1,'L'=>0,'XL'=>3],'imagenes'=>['nomadic1.webp','nomadic2.webp']],
                ]
            ],
            [
                'nombre' => 'Polo Stop Wars Boxy',
                'precio' => 65.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Expresso','tallas'=>['S'=>14,'M'=>3,'L'=>7,'XL'=>4],'imagenes'=>['stopwars1.webp','stopwars2.webp']],
                ]
            ],
        ];

        foreach ($productosPolos as $prod) {
            $producto = Producto::create([
                'categoria_id' => $polos->id,
                'marca_id' => $marca->id,
                'nombre' => $prod['nombre'],
                'slug' => Str::slug($prod['nombre']),
                'precio' => $prod['precio'],
                'activo' => 1,
                'nuevo' => $prod['nuevo'] ?? false,
            ]);

            foreach ($prod['variantes'] as $var) {
                // Crear todas las tallas de la variante
                foreach ($var['tallas'] as $talla => $stock) {
                    $variante = Variante::create([
                        'producto_id' => $producto->id,
                        'talla' => $talla,
                        'color' => $var['color'],
                        'stock' => $stock,
                        'stock_reservado' => 0,
                        'sku' => strtoupper($producto->slug.'-'.$var['color'].'-'.$talla),
                    ]);

                    // Crear imágenes por color (para todas las tallas se repiten)
                    foreach ($var['imagenes'] as $index => $img) {
                        Imagen::create([
                            'variante_id' => $variante->id,
                            'ruta' => $img,
                            'orden' => $index+1,
                        ]);
                    }
                }
            }
        }

        // ===========================
        // Productos Casacas (no New Arrival)
        // ===========================
        $productosCasacas = [
                [
                'nombre' => 'Casaca Wheeler',
                'precio' => 125.00,
                'nuevo' => false,
                'variantes' => [
                    ['color'=>'Negro','tallas'=>['S'=>20,'M'=>20,'L'=>10,'XL'=>0],'imagenes'=>['wheeler.webp','wheeler2.webp','wheeler3.webp','wheeler4.webp','wheeler5.webp']],
                ]
            ],
                [
                'nombre' => 'Casaca Trek',
                'precio' => 219.90,
                'nuevo' => false,
                'variantes' => [
                    ['color'=>'Verde-Claro','tallas'=>['S'=>5,'M'=>13,'L'=>11,'XL'=>0],'imagenes'=>['trek.webp','trek2.webp','trek3.webp','trek4.webp','trek5.webp']],
                    ['color'=>'Negro','tallas'=>['S'=>2,'M'=>7,'L'=>5,'XL'=>0],'imagenes'=>['trekn.webp','trekn2.webp','trekn3.webp','trekn4.webp','trekn5.webp']],
                ]
            ],
                [
                'nombre' => 'Casaca Quik',
                'precio' => 199.90,
                'nuevo' => false,
                'variantes' => [
                    ['color'=>'Negro','tallas'=>['S'=>17,'M'=>23,'L'=>26,'XL'=>12],'imagenes'=>['quik.webp','quik2.webp','quik3.webp','quik4.webp','quik5.webp']],
                    ['color'=>'Beige','tallas'=>['S'=>17,'M'=>22,'L'=>13,'XL'=>9],'imagenes'=>['quikb.webp','quikb2.webp','quikb3.webp','quikb4.webp','quikb5.webp']],
                ]
            ],
                [
                'nombre' => 'Casaca Carnero Lond',
                'precio' => 170.00,
                'nuevo' => false,
                'variantes' => [
                    ['color'=>'Negro','tallas'=>['S'=>3,'M'=>3,'L'=>5,'XL'=>2],'imagenes'=>['carnero.webp','carnero2.webp','carnero3.webp','carnero4.webp','carnero5.webp']],
                    ['color'=>'Beige','tallas'=>['S'=>5,'M'=>3,'L'=>9,'XL'=>4],'imagenes'=>['carn.webp','carn2.webp','carn3.webp','carn4.webp','carn5.webp']],
                ]
            ],
                [
                'nombre' => 'Casaca Counter',
                'precio' => 99.90,
                'nuevo' => false,
                'variantes' => [
                    ['color'=>'Verde-Oscuro','tallas'=>['S'=>3,'M'=>0,'L'=>0,'XL'=>14],'imagenes'=>['counter.webp','counter2.webp']],
                ]
            ],
                [
                'nombre' => 'Casaca Boxy Fit Nomad',
                'precio' => 149.90,
                'nuevo' => false,
                'variantes' => [
                    ['color'=>'Lila','tallas'=>['S'=>8,'M'=>20,'L'=>17,'XL'=>7],'imagenes'=>['boxy.webp','boxy2.webp','boxy3.webp','boxy4.webp']],
                    ['color'=>'Verde-Oscuro','tallas'=>['S'=>68,'M'=>32,'L'=>11,'XL'=>40],'imagenes'=>['boxye.webp','boxye2.webp','boxye3.webp','boxye4.webp']],
                ]
            ],
            // ... otras casacas
        ];

        foreach ($productosCasacas as $prod) {
            $producto = Producto::create([
                'categoria_id' => $casacas->id,
                'marca_id' => $marca->id,
                'nombre' => $prod['nombre'],
                'slug' => Str::slug($prod['nombre']),
                'precio' => $prod['precio'],
                'activo' => 1,
                'nuevo' => $prod['nuevo'] ?? false,
            ]);

            foreach ($prod['variantes'] as $var) {
                foreach ($var['tallas'] as $talla => $stock) {
                    $variante = Variante::create([
                        'producto_id' => $producto->id,
                        'talla' => $talla,
                        'color' => $var['color'],
                        'stock' => $stock,
                        'stock_reservado' => 0,
                        'sku' => strtoupper($producto->slug.'-'.$var['color'].'-'.$talla),
                    ]);

                    foreach ($var['imagenes'] as $index => $img) {
                        Imagen::create([
                            'variante_id' => $variante->id,
                            'ruta' => $img,
                            'orden' => $index+1,
                        ]);
                    }
                }
            }
        }

        // ===========================
        // Productos Bividis (New Arrival)
        // ===========================
        $productosBividis = [
            [
                'nombre' => 'Bividi Blanco',
                'precio' => 65.00,
                'nuevo' => true,
                'variantes' => [
                    ['color'=>'Blanco','tallas'=>['M'=>5],'imagenes'=>['bividi1.webp','bividi2.webp']],
                ]
            ],
        ];

        foreach ($productosBividis as $prod) {
            $producto = Producto::create([
                'categoria_id' => $bividis->id,
                'marca_id' => $marca->id,
                'nombre' => $prod['nombre'],
                'slug' => Str::slug($prod['nombre']),
                'precio' => $prod['precio'],
                'activo' => 1,
                'nuevo' => $prod['nuevo'] ?? false,
            ]);

            foreach ($prod['variantes'] as $var) {
                foreach ($var['tallas'] as $talla => $stock) {
                    $variante = Variante::create([
                        'producto_id' => $producto->id,
                        'talla' => $talla,
                        'color' => $var['color'],
                        'stock' => $stock,
                        'stock_reservado' => 0,
                        'sku' => strtoupper($producto->slug.'-'.$var['color'].'-'.$talla),
                    ]);

                    foreach ($var['imagenes'] as $index => $img) {
                        Imagen::create([
                            'variante_id' => $variante->id,
                            'ruta' => $img,
                            'orden' => $index+1,
                        ]);
                    }
                }
            }
        }
    }
}