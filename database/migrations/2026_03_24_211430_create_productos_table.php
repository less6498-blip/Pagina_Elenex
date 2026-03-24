<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con categorias y marca
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('marca_id')->constrained('marcas');

            // 📍 Datos de dirección
            $table->string('nombre');
            $table->string('talla');
            $table->string('color');
            $table->integer('stock');
            $table->string('imagen')->nullable();
            $table->string('slug')->unique();
            $table->decimal('precio', 10, 2);
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
