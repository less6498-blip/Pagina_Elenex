<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
       Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con clientes y direccion
            $table->foreignId('cliente_id')->constrained('clientes')
            ->cascadeOnDelete();
            $table->foreignId('direccion_id')->constrained('direcciones');

            // 📍 Datos de dirección
            $table->string('estado');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento_total', 10, 2)->default(0);
            $table->decimal('impuesto', 10, 2);
            $table->string('metodo_pago');
            $table->string('estado_pago');
            $table->decimal('costo_envio', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamp('fecha')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
