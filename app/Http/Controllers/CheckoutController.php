<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Mostrar página de checkout
    public function index()
    {
        return view('checkout.index');
    }

    // Procesar pedido (sin pago por ahora)
    public function procesar(Request $request)
    {
        // 1. Validar
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'email'        => 'required|email|max:100',
            'telefono'     => 'nullable|string|max:20',
            'departamento' => 'required|string',
            'provincia'    => 'required|string',
            'distrito'     => 'required|string',
            'direccion'    => 'required|string|max:200',
            'referencia'   => 'nullable|string|max:200',
            'zona_envio'   => 'required|in:lima,provincias',
            'cart_items'   => 'required|string',
        ]);

        // 2. Decodificar carrito
        $items = json_decode($request->cart_items, true);

        if (empty($items)) {
            return response()->json(['error' => 'El carrito está vacío'], 422);
        }

        // 3. Calcular totales
        $subtotal   = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);
        $costoEnvio = $request->zona_envio === 'lima' ? 10.00 : 20.00;
        $total      = $subtotal + $costoEnvio;

        // 4. Crear pedido
        $pedido = Pedido::create([
            'guest_nombre'       => $request->nombre,
            'guest_email'        => $request->email,
            'guest_telefono'     => $request->telefono,
            'envio_departamento' => $request->departamento,
            'envio_provincia'    => $request->provincia,
            'envio_distrito'     => $request->distrito,
            'envio_direccion'    => $request->direccion,
            'envio_referencia'   => $request->referencia,
            'subtotal'           => $subtotal,
            'costo_envio'        => $costoEnvio,
            'total'              => $total,
            'estado'             => 'confirmado',
            'estado_pago'        => 'pendiente', // cambiará a 'pagado' con Culqi
            'metodo_pago'        => 'pendiente',
            'codigo_orden'       => 'ELX-' . strtoupper(Str::random(8)),
        ]);

        // 5. Guardar items
        foreach ($items as $item) {
            DetallePedido::create([
                'pedido_id'        => $pedido->id,
                'producto_id'      => $item['id'] ?? null,
                'nombre_producto'  => $item['name'],
                'variante_detalle' => $item['variant'] ?? null,
                'imagen_url'       => $item['image'] ?? null,
                'cantidad'         => $item['quantity'],
                'precio_unitario'  => $item['price'],
                'subtotal'         => $item['price'] * $item['quantity'],
            ]);
        }

        return response()->json([
            'success'      => true,
            'codigo_orden' => $pedido->codigo_orden,
            'redirect'     => route('checkout.confirmacion', $pedido->codigo_orden),
        ]);
    }

    // Página de confirmación
    public function confirmacion($codigo)
    {
        $pedido = Pedido::with('detalles')
                        ->where('codigo_orden', $codigo)
                        ->firstOrFail();

        return view('checkout.confirmacion', compact('pedido'));
    }
}