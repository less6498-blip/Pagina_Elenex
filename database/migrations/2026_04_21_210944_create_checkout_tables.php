<?php
use Illuminate\Support\Facades\DB;  // ← agregar esta línea
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Desactivar validación de foreign keys temporalmente
    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    Schema::dropIfExists('pagos');
    Schema::dropIfExists('detalle_pedidos');
    Schema::dropIfExists('pedidos');

    // Reactivar
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    // ... resto del código igual

    // ── pedidos ───────────────────────────────────────
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        $table->string('guest_nombre');
        $table->string('guest_email');
        $table->string('guest_telefono')->nullable();
        $table->string('envio_departamento');
        $table->string('envio_provincia');
        $table->string('envio_distrito');
        $table->string('envio_direccion');
        $table->string('envio_referencia')->nullable();
        $table->decimal('subtotal', 10, 2);
        $table->decimal('costo_envio', 10, 2)->default(0);
        $table->decimal('total', 10, 2);
        $table->enum('estado', ['pendiente','confirmado','enviado','entregado','cancelado'])->default('pendiente');
        $table->enum('estado_pago', ['pendiente','pagado','fallido'])->default('pendiente');
        $table->string('metodo_pago')->default('pendiente');
        $table->string('codigo_orden')->unique();
        $table->timestamps();
    });

    // ── detalle_pedidos ───────────────────────────────
    Schema::create('detalle_pedidos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
        $table->unsignedBigInteger('producto_id')->nullable();
        $table->string('nombre_producto');
        $table->string('variante_detalle')->nullable();
        $table->string('imagen_url', 500)->nullable();
        $table->integer('cantidad');
        $table->decimal('precio_unitario', 10, 2);
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();
    });

    // ── pagos ─────────────────────────────────────────
    Schema::create('pagos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
        $table->string('culqi_charge_id')->nullable();
        $table->decimal('monto', 10, 2);
        $table->string('moneda')->default('PEN');
        $table->enum('estado', ['pendiente','exitoso','fallido'])->default('pendiente');
        $table->string('marca_tarjeta')->nullable();
        $table->string('ultimos_digitos')->nullable();
        $table->text('respuesta_completa')->nullable();
        $table->timestamps();
    });
}
};