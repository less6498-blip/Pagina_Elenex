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
            $table->foreignId('producto_id')->constrained('productos')
            ->cascadeOnDelete();


            // 📍 Datos de dirección
            $table->string('talla');
            $table->string('color');
            $table->integer('stock');
            $table->integer('stock_reservado')->default(0);
            $table->string('sku')->unique();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('variantes');
    }
};
