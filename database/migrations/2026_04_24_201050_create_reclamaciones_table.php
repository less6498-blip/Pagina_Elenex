<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique()->comment('Código único de seguimiento');

            // Datos del consumidor
            $table->enum('tipo_documento', ['DNI', 'CE', 'RUC', 'PASAPORTE']);
            $table->string('numero_documento', 15);
            $table->string('nombres', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->string('telefono', 20);
            $table->string('correo', 150);
            $table->boolean('es_menor')->default(false);
            $table->string('direccion', 255);

            // Bien contratado
            $table->enum('tipo_bien', ['PRODUCTO', 'SERVICIO']);
            $table->decimal('monto_reclamado', 10, 2)->nullable();
            $table->text('descripcion_bien');

            // Reclamación
            $table->enum('tipo_reclamo', ['RECLAMO', 'QUEJA']);
            $table->text('detalle_reclamo');
            $table->text('pedido_consumidor');

            // Estado y seguimiento
            $table->enum('estado', ['PENDIENTE', 'EN_PROCESO', 'RESUELTO', 'CERRADO'])
                  ->default('PENDIENTE');
            $table->text('respuesta')->nullable()->comment('Respuesta del proveedor');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->string('ip_registro', 45)->nullable();

            $table->timestamps();

            // Índices para búsquedas comunes
            $table->index('codigo');
            $table->index('correo');
            $table->index('numero_documento');
            $table->index('estado');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamaciones');
    }
};