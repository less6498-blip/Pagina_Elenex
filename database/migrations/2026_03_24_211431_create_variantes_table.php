<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con producto
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();

            // 📍 Datos de la variante
            $table->string('talla');
            $table->string('color');
            $table->integer('stock');
            $table->integer('stock_reservado')->default(0);
            $table->string('sku')->unique();

            // 📷 Imágenes por variante (1 y 2, más adelante 3 y 4)
            $table->string('imagen1')->nullable();
            $table->string('imagen2')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes');
    }
};
