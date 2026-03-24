<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación 
            $table->foreignId('padre_id')->nullable()->constrained('categorias');

            // 📍 Datos de dirección
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('slug')->unique();

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
