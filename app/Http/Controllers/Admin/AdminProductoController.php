<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Variante;
use App\Models\Imagen;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Str;

class AdminProductoController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_productos'  => Producto::count(),
            'productos_activos'=> Producto::where('activo', 1)->count(),
            'total_variantes'  => Variante::count(),
            'sin_stock'        => Variante::where('stock', 0)->count(),
        ];
        $ultimos = Producto::with('categoria')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'ultimos'));
    }

    // ── Lista de productos ────────────────────────────────
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'variantes', 'variantes.imagenes']);

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        $productos   = $query->latest()->paginate(20);
        $categorias  = Categoria::all();
        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    // ── Formulario crear ─────────────────────────────────
    public function crear()
    {
        $categorias = Categoria::all();
        $marcas     = Marca::all();
        return view('admin.productos.crear', compact('categorias', 'marcas'));
    }

    // ── Guardar nuevo producto ────────────────────────────
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:200',
            'categoria_id' => 'required|exists:categorias,id',
            'precio'       => 'required|numeric|min:0',
            'variantes'    => 'required|array|min:1',
            'variantes.*.talla' => 'required|string',
            'variantes.*.color' => 'required|string',
            'variantes.*.stock' => 'required|integer|min:0',
        ]);

        // 1. Crear producto
        $producto = Producto::create([
            'nombre'       => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'marca_id'     => $request->marca_id,
            'precio'       => $request->precio,
            'slug'         => Str::slug($request->nombre) . '-' . uniqid(),
            'activo'       => $request->has('activo') ? 1 : 0,
            'nuevo'        => $request->has('nuevo') ? 1 : 0,
        ]);

        // 2. Crear variantes e imágenes
        foreach ($request->variantes as $idx => $varData) {
            $variante = Variante::create([
                'producto_id'     => $producto->id,
                'talla'           => $varData['talla'],
                'color'           => $varData['color'],
                'stock'           => $varData['stock'],
                'sku'             => strtoupper(Str::random(8)),
            ]);

            // Subir imágenes de esta variante
            if ($request->hasFile("imagenes.$idx")) {
                foreach ($request->file("imagenes.$idx") as $orden => $img) {
                    $nombre = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('img'), $nombre);

                    Imagen::create([
                        'variante_id' => $variante->id,
                        'ruta'        => $nombre,
                        'orden'       => $orden,
                    ]);
                }
            }
        }

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto creado correctamente ✅');
    }

    // ── Formulario editar ─────────────────────────────────
    public function editar($id)
    {
        $producto   = Producto::with(['variantes.imagenes'])->findOrFail($id);
        $categorias = Categoria::all();
        $marcas     = Marca::all();
        return view('admin.productos.editar', compact('producto', 'categorias', 'marcas'));
    }

    // ── Actualizar producto ───────────────────────────────
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre'       => 'required|string|max:200',
            'categoria_id' => 'required|exists:categorias,id',
            'precio'       => 'required|numeric|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update([
            'nombre'       => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'marca_id'     => $request->marca_id,
            'precio'       => $request->precio,
            'activo'       => $request->has('activo') ? 1 : 0,
            'nuevo'        => $request->has('nuevo') ? 1 : 0,
        ]);

        // Actualizar stock de variantes existentes
        if ($request->filled('variantes_existentes')) {
            foreach ($request->variantes_existentes as $varId => $varData) {
                Variante::where('id', $varId)->update([
                    'talla' => $varData['talla'],
                    'color' => $varData['color'],
                    'stock' => $varData['stock'],
                ]);

                // Nuevas imágenes para variante existente
                if ($request->hasFile("nuevas_imagenes.$varId")) {
                    $ultimoOrden = Imagen::where('variante_id', $varId)->max('orden') ?? -1;
                    foreach ($request->file("nuevas_imagenes.$varId") as $img) {
                        $nombre = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                        $img->move(public_path('img'), $nombre);
                        Imagen::create([
                            'variante_id' => $varId,
                            'ruta'        => $nombre,
                            'orden'       => ++$ultimoOrden,
                        ]);
                    }
                }
            }
        }

        // Agregar nuevas variantes
        if ($request->filled('nuevas_variantes')) {
            foreach ($request->nuevas_variantes as $idx => $varData) {
                if (empty($varData['talla']) || empty($varData['color'])) continue;

                $variante = Variante::create([
                    'producto_id' => $producto->id,
                    'talla'       => $varData['talla'],
                    'color'       => $varData['color'],
                    'stock'       => $varData['stock'] ?? 0,
                    'sku'         => strtoupper(Str::random(8)),
                ]);

                if ($request->hasFile("imagenes_nuevas_variantes.$idx")) {
                    foreach ($request->file("imagenes_nuevas_variantes.$idx") as $orden => $img) {
                        $nombre = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                        $img->move(public_path('img'), $nombre);
                        Imagen::create([
                            'variante_id' => $variante->id,
                            'ruta'        => $nombre,
                            'orden'       => $orden,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.productos.editar', $id)
                         ->with('success', 'Producto actualizado correctamente ✅');
    }

    // ── Eliminar producto ─────────────────────────────────
    public function eliminar($id)
    {
        $producto = Producto::with('variantes.imagenes')->findOrFail($id);

        // Eliminar imágenes físicas
        foreach ($producto->variantes as $variante) {
            foreach ($variante->imagenes as $imagen) {
                $ruta = public_path('img/' . $imagen->ruta);
                if (file_exists($ruta)) unlink($ruta);
            }
        }

        $producto->delete();
        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto eliminado ✅');
    }

    // ── Eliminar variante ─────────────────────────────────
    public function eliminarVariante($id)
    {
        $variante = Variante::with('imagenes')->findOrFail($id);
        foreach ($variante->imagenes as $imagen) {
            $ruta = public_path('img/' . $imagen->ruta);
            if (file_exists($ruta)) unlink($ruta);
        }
        $variante->delete();
        return response()->json(['success' => true]);
    }

    // ── Eliminar imagen ───────────────────────────────────
    public function eliminarImagen($id)
    {
        $imagen = Imagen::findOrFail($id);
        $ruta   = public_path('img/' . $imagen->ruta);
        if (file_exists($ruta)) unlink($ruta);
        $imagen->delete();
        return response()->json(['success' => true]);
    }
}