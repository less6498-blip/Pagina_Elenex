<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Pago;
use App\Models\Product;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function procesar(Request $request)
    {
        // ======================
        // VALIDACIÓN
        // ======================
        $request->validate([
            'nombre'       => ['required','string','max:100','regex:/^[\pL\s]+$/u'],
            'email'        => 'required|email|max:100',
            'telefono'     => 'nullable|digits:9',
            'dni'          => 'required|digits:8',
            'departamento' => 'required|string',
            'provincia'    => 'required|string',
            'distrito'     => 'required|string',
            'direccion'    => 'required|string|max:200',
            'referencia'   => 'nullable|string|max:200',
            'culqi_token'  => 'required|string',
            'cart_items'   => 'required|array',
            'zona_envio'   => 'required|in:lima,provincias',
        ]);

        $items = $request->cart_items;

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'error' => 'El carrito está vacío'
            ], 422);
        }

        // ======================
        // 1. VALIDAR STOCK + SUBTOTAL
        // ======================
        $subtotal = 0;

        foreach ($items as $item) {

            $producto = Product::find($item['id']);

            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'error' => 'Producto no existe'
                ], 422);
            }

            if ($producto->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'error' => "Stock insuficiente para {$producto->name}"
                ], 422);
            }

            $subtotal += $producto->price * $item['quantity'];
        }

        // ======================
        // 2. ENVÍO + TOTAL
        // ======================
        $costoEnvio = $request->zona_envio === 'lima' ? 10 : 20;
        $total = $subtotal + $costoEnvio;

        // ======================
        // 3. EVITAR DOBLE PAGO (básico)
        // ======================
        $ultimoPedido = Pedido::where('guest_email', $request->email)
            ->where('estado_pago', 'pagado')
            ->latest()
            ->first();

        if ($ultimoPedido) {
            return response()->json([
                'success' => false,
                'error' => 'Ya existe un pago reciente con este email'
            ], 422);
        }

        // ======================
        // 4. COBRO CULQI
        // ======================
        try {

            $culqi = new \Culqi\Culqi([
                'api_key' => env('CULQI_SECRET_KEY')
            ]);

            $cargo = $culqi->Charges->create([
                'amount'        => intval($total * 100),
                'currency_code' => 'PEN',
                'email'         => $request->email,
                'source_id'     => $request->culqi_token,
                'description'   => 'Pedido - ' . $request->nombre,
                'capture'       => true,
            ]);

            if (!isset($cargo->id)) {
                throw new \Exception('Pago no procesado');
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error en Culqi: ' . $e->getMessage()
            ], 422);
        }

        // ======================
        // 5. CREAR PEDIDO
        // ======================
        $codigo = 'ELX-' . strtoupper(Str::random(8));

        $pedido = Pedido::create([
            'guest_nombre'       => $request->nombre,
            'guest_email'        => $request->email,
            'guest_telefono'     => $request->telefono,
            'guest_dni'          => $request->dni,
            'envio_departamento' => $request->departamento,
            'envio_provincia'    => $request->provincia,
            'envio_distrito'     => $request->distrito,
            'envio_direccion'    => $request->direccion,
            'envio_referencia'   => $request->referencia,
            'subtotal'           => $subtotal,
            'costo_envio'        => $costoEnvio,
            'total'              => $total,
            'estado'             => 'confirmado',
            'estado_pago'        => 'pagado',
            'metodo_pago'        => 'culqi',
            'codigo_orden'       => $codigo,
        ]);

        // ======================
        // 6. GUARDAR DETALLES + DESCONTAR STOCK
        // ======================
        foreach ($items as $item) {

            $producto = Product::find($item['id']);

            DetallePedido::create([
                'pedido_id'        => $pedido->id,
                'producto_id'      => $producto->id,
                'nombre_producto'  => $producto->name,
                'cantidad'         => $item['quantity'],
                'precio_unitario'  => $producto->price,
                'subtotal'         => $producto->price * $item['quantity'],
            ]);

            // 🔥 DESCONTAR STOCK AQUÍ (solo si pago fue exitoso)
            $producto->stock -= $item['quantity'];
            $producto->save();
        }

        // ======================
        // 7. REGISTRAR PAGO
        // ======================
        Pago::create([
            'pedido_id'          => $pedido->id,
            'culqi_charge_id'    => $cargo->id,
            'monto'              => $total,
            'moneda'             => 'PEN',
            'estado'             => 'exitoso',
            'respuesta_completa' => json_encode($cargo),
        ]);

        // ======================
        // 8. RESPUESTA FRONT
        // ======================
        return response()->json([
            'success'      => true,
            'codigo_orden' => $codigo,
            'redirect'     => route('checkout.confirmacion', $codigo),
        ]);
    }

    public function confirmacion($codigo)
    {
        $pedido = Pedido::with('detalles')
            ->where('codigo_orden', $codigo)
            ->firstOrFail();

        return view('checkout.confirmacion', compact('pedido'));
    }
}