<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con pedidos
            $table->foreignId('pedido_id')->constrained('pedidos')
            ->cascadeOnDelete();

            // 📍 Datos de dirección
            $table->string('metodo_pago');
            $table->string('estado_pago');
            $table->string('proveedor')->nullable();
            $table->string('estado');
            $table->decimal('monto', 10, 2);
            $table->timestamp('fecha_pago')->nullable();


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
