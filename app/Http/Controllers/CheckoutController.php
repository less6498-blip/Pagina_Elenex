<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Pago;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'email'        => 'required|email|max:100',
            'telefono'     => 'nullable|string|max:20',
            'departamento' => 'required|string',
            'provincia'    => 'required|string',
            'distrito'     => 'required|string',
            'direccion'    => 'required|string|max:200',
            'referencia'   => 'nullable|string|max:200',
            'culqi_token'  => 'required|string',
            'cart_items'   => 'required|array',
            'zona_envio'   => 'required|in:lima,provincias',
        ]);

        $items     = $request->cart_items;
        $zonaEnvio = $request->zona_envio;

        if (empty($items)) {
            return response()->json(['error' => 'El carrito está vacío'], 422);
        }

        // Calcular totales
        $subtotal        = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);
        $costoEnvio      = $zonaEnvio === 'lima' ? 10.00 : 20.00;
        $total           = $subtotal + $costoEnvio;
        $totalCentimos   = (int) round($total * 100);

        // Cobrar con Culqi
        try {
            $culqi = new \Culqi\Culqi(['api_key' => env('CULQI_SECRET_KEY')]);

            $cargo = $culqi->Charges->create([
                'amount'        => $totalCentimos,
                'currency_code' => 'PEN',
                'email'         => $request->email,
                'source_id'     => $request->culqi_token,
                'description'   => 'Pedido Elenex - ' . $request->nombre,
                'capture'       => true,
                'antifraud_details' => [
                    'first_name'   => explode(' ', $request->nombre)[0],
                    'last_name'    => explode(' ', $request->nombre)[1] ?? '',
                    'phone_number' => $request->telefono ?? '999999999',
                    'address'      => $request->direccion,
                    'address_city' => $request->provincia,
                    'country_code' => 'PE',
                ],
            ]);

            if (!isset($cargo->id)) {
                throw new \Exception('No se recibió confirmación de Culqi');
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el pago: ' . $e->getMessage()
            ], 422);
        }

        // Guardar pedido
        $codigoOrden = 'ELX-' . strtoupper(Str::random(8));

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
            'estado_pago'        => 'pagado',
            'metodo_pago'        => 'culqi',
            'codigo_orden'       => $codigoOrden,
        ]);

        // Guardar items
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

        // Guardar pago
        Pago::create([
            'pedido_id'          => $pedido->id,
            'culqi_charge_id'    => $cargo->id,
            'monto'              => $total,
            'moneda'             => 'PEN',
            'estado'             => 'exitoso',
            'marca_tarjeta'      => $cargo->source->card_brand ?? null,
            'ultimos_digitos'    => $cargo->source->last_four ?? null,
            'respuesta_completa' => json_encode($cargo),
        ]);

        return response()->json([
            'success'      => true,
            'codigo_orden' => $codigoOrden,
            'redirect'     => route('checkout.confirmacion', $codigoOrden),
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