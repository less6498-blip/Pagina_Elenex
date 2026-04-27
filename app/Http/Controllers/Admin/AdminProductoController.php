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
            'sin_stock' => Variante::where('stock', 0)->count(), // variantes sin stock
            'productos_sin_stock' => Producto::whereHas('variantes', function($q) {
            $q->where('stock', 0);
            })->count(),
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
    // Filtro de stock
    if ($request->filled('stock')) {
    if ($request->stock === 'sin_stock') {
        $query->whereHas('variantes', function($q) {
            $q->where('stock', 0);
        });
    } elseif ($request->stock === 'bajo_stock') {
        $query->whereHas('variantes', function($q) {
            $q->where('stock', '>', 0)->where('stock', '<=', 5);
        });
    } elseif ($request->stock === 'con_stock') {
        $query->whereHas('variantes', function($q) {
            $q->where('stock', '>', 5);
        });
    }
}

    $productos  = $query->latest()->paginate(20);
    $categorias = Categoria::all();
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

    // ── Descargar plantilla Excel ─────────────────────────
public function descargarPlantilla()
{
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Productos');

    // ── Headers ──────────────────────────────────────────
    $headers = [
        'A1' => 'nombre',
        'B1' => 'precio',
        'C1' => 'categoria',
        'D1' => 'marca',
        'E1' => 'activo (1/0)',
        'F1' => 'nuevo (1/0)',
        'G1' => 'talla',
        'H1' => 'color',
        'I1' => 'stock',
        'J1' => 'imagen_url (opcional)',
    ];

    foreach ($headers as $cell => $value) {
        $sheet->setCellValue($cell, $value);
    }

    // ── Estilo headers ────────────────────────────────────
    $headerStyle = [
        'font' => [
            'bold'  => true,
            'color' => ['rgb' => 'FFFFFF'],
            'size'  => 11,
        ],
        'fill' => [
            'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '111111'],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color'       => ['rgb' => 'DDDDDD'],
            ],
        ],
    ];
    $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

    // ── Filas de ejemplo ──────────────────────────────────
    $ejemplos = [
        ['Polo Mojito Oversize', 75.00, 'Polos',   'Elenex', 1, 1, 'S',  'blanco', 10, ''],
        ['Polo Mojito Oversize', 75.00, 'Polos',   'Elenex', 1, 1, 'M',  'blanco', 15, ''],
        ['Polo Mojito Oversize', 75.00, 'Polos',   'Elenex', 1, 1, 'L',  'blanco', 8,  ''],
        ['Polo Mojito Oversize', 75.00, 'Polos',   'Elenex', 1, 1, 'XL', 'blanco', 5,  ''],
        ['Casaca Wheeler',      125.00, 'Casacas', 'Elenex', 1, 0, 'S',  'negro',  10, ''],
        ['Casaca Wheeler',      125.00, 'Casacas', 'Elenex', 1, 0, 'M',  'negro',  12, ''],
    ];

    $fila = 2;
    foreach ($ejemplos as $ejemplo) {
        $sheet->fromArray($ejemplo, null, 'A' . $fila);

        // Estilo filas de ejemplo (gris claro)
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray([
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F5F5F5'],
            ],
            'font' => ['color' => ['rgb' => '888888'], 'italic' => true],
        ]);
        $fila++;
    }

    // ── Fila vacía para que el usuario llene ──────────────
    $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray([
        'fill' => [
            'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFDE7'],
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color'       => ['rgb' => 'FFD600'],
            ],
        ],
    ]);

    // ── Ancho de columnas ─────────────────────────────────
    $anchos = ['A'=>28,'B'=>10,'C'=>15,'D'=>12,'E'=>14,'F'=>13,'G'=>8,'H'=>12,'I'=>8,'J'=>25];
    foreach ($anchos as $col => $ancho) {
        $sheet->getColumnDimension($col)->setWidth($ancho);
    }

    // ── Hoja de instrucciones ─────────────────────────────
    $instrucciones = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Instrucciones');
    $spreadsheet->addSheet($instrucciones);
    $instrucciones->setCellValue('A1', 'INSTRUCCIONES DE USO');
    $instrucciones->setCellValue('A3', '1. Ve a la hoja "Productos"');
    $instrucciones->setCellValue('A4', '2. Las filas grises son ejemplos — puedes borrarlas');
    $instrucciones->setCellValue('A5', '3. Escribe una fila por cada variante (talla + color)');
    $instrucciones->setCellValue('A6', '4. Si un polo tiene 4 tallas, escribe 4 filas con el mismo nombre');
    $instrucciones->setCellValue('A7', '5. activo: 1 = visible en tienda, 0 = oculto');
    $instrucciones->setCellValue('A8', '6. nuevo: 1 = aparece en New Arrivals, 0 = no');
    $instrucciones->setCellValue('A9', '7. Las categorías y marcas se crean automáticamente si no existen');
    $instrucciones->setCellValue('A11', 'TALLAS VÁLIDAS:');
    $instrucciones->setCellValue('A12', 'XS, S, M, L, XL, XXL, XXXL, Única');
    $instrucciones->setCellValue('A14', 'EJEMPLO DE PRODUCTO CON 2 COLORES Y 2 TALLAS:');
    $instrucciones->fromArray([
        ['nombre',    'precio', 'categoria', 'talla', 'color',  'stock'],
        ['Polo Trek', '75.00',  'Polos',     'S',     'negro',  '10'],
        ['Polo Trek', '75.00',  'Polos',     'M',     'negro',  '15'],
        ['Polo Trek', '75.00',  'Polos',     'S',     'blanco', '8'],
        ['Polo Trek', '75.00',  'Polos',     'M',     'blanco', '12'],
    ], null, 'A15');

    $instrucciones->getStyle('A1')->applyFromArray([
        'font' => ['bold' => true, 'size' => 14],
    ]);
    $instrucciones->getColumnDimension('A')->setWidth(50);

    // ── Activar hoja Productos ────────────────────────────
    $spreadsheet->setActiveSheetIndex(0);

    // ── Generar descarga ──────────────────────────────────
    $writer   = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $filename = 'plantilla_elenex_' . date('Y-m-d') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
}