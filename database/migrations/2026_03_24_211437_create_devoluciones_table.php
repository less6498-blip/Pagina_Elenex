<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('detalle_pedido_id')->constrained('detalle_pedidos')->cascadeOnDelete();

            $table->string('motivo');
            $table->string('estado');
            $table->decimal('monto_reembolso', 10, 2);
            $table->text('descripcion')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
