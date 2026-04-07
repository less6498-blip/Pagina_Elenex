<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con la variante
            $table->foreignId('variante_id')->constrained('variantes')->cascadeOnDelete();

            // 📍 Datos de la imagen
            $table->string('ruta'); // nombre del archivo o ruta relativa
            $table->integer('orden')->default(1); // permite definir el orden de visualización
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};