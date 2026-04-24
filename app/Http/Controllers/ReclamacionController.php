<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReclamacionController extends Controller
{
    /**
     * Muestra el formulario del Libro de Reclamaciones.
     */
    public function create()
    {
        return view('reclamaciones.create');
    }

    /**
     * Procesa y almacena la reclamación.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_documento'     => 'required|in:DNI,CE,RUC,PASAPORTE',
            'numero_documento'   => 'required|string|max:15',
            'nombres'            => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'required|string|max:100',
            'telefono'           => 'required|string|max:20',
            'correo'             => 'required|email|max:150',
            'es_menor'           => 'nullable|boolean',
            'direccion'          => 'required|string|max:255',
            'tipo_bien'          => 'required|in:PRODUCTO,SERVICIO',
            'monto_reclamado'    => 'nullable|numeric|min:0',
            'descripcion_bien'   => 'required|string|max:500',
            'tipo_reclamo'       => 'required|in:RECLAMO,QUEJA',
            'detalle_reclamo'    => 'required|string|max:2000',
            'pedido_consumidor'  => 'required|string|max:1000',
            'acepta_politica'    => 'accepted',
        ], [
            'tipo_documento.required'    => 'Seleccione el tipo de documento.',
            'tipo_documento.in'          => 'Tipo de documento inválido.',
            'numero_documento.required'  => 'Ingrese el número de documento.',
            'nombres.required'           => 'Ingrese sus nombres.',
            'apellido_paterno.required'  => 'Ingrese el apellido paterno.',
            'apellido_materno.required'  => 'Ingrese el apellido materno.',
            'telefono.required'          => 'Ingrese un teléfono de contacto.',
            'correo.required'            => 'Ingrese su correo electrónico.',
            'correo.email'               => 'Ingrese un correo electrónico válido.',
            'direccion.required'         => 'Ingrese su dirección.',
            'tipo_bien.required'         => 'Seleccione el tipo de bien.',
            'descripcion_bien.required'  => 'Describa el producto o servicio.',
            'tipo_reclamo.required'      => 'Seleccione el tipo de reclamación.',
            'detalle_reclamo.required'   => 'Detalle su reclamación.',
            'pedido_consumidor.required' => 'Indique su pedido o pretensión.',
            'acepta_politica.accepted'   => 'Debe aceptar la política de datos personales.',
        ]);

        // Generar código único de reclamo
        $codigoReclamo = 'REC-' . date('Y') . '-' . strtoupper(Str::random(8));

        // Guardar en base de datos
        $reclamacion = Reclamacion::create([
            'codigo'             => $codigoReclamo,
            'tipo_documento'     => $validated['tipo_documento'],
            'numero_documento'   => $validated['numero_documento'],
            'nombres'            => $validated['nombres'],
            'apellido_paterno'   => $validated['apellido_paterno'],
            'apellido_materno'   => $validated['apellido_materno'],
            'telefono'           => $validated['telefono'],
            'correo'             => $validated['correo'],
            'es_menor'           => $request->boolean('es_menor'),
            'direccion'          => $validated['direccion'],
            'tipo_bien'          => $validated['tipo_bien'],
            'monto_reclamado'    => $validated['monto_reclamado'] ?? null,
            'descripcion_bien'   => $validated['descripcion_bien'],
            'tipo_reclamo'       => $validated['tipo_reclamo'],
            'detalle_reclamo'    => $validated['detalle_reclamo'],
            'pedido_consumidor'  => $validated['pedido_consumidor'],
            'estado'             => 'PENDIENTE',
            'ip_registro'        => $request->ip(),
        ]);

        // Enviar correo de confirmación al consumidor (opcional)
        // Mail::to($validated['correo'])->send(new ReclamacionConfirmacion($reclamacion));

        return redirect()->route('reclamaciones.create')
            ->with('reclamo_registrado', true)
            ->with('codigo_reclamo', $codigoReclamo)
            ->with('correo_reclamo', $validated['correo']);
    }
}