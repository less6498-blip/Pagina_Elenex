<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con clientes
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnDelete();

            // 📍 Datos de dirección
            $table->string('departamento');
            $table->string('provincia');
            $table->string('distrito');
            $table->string('codigo_postal')->nullable();
            $table->string('direccion');

            // ⭐ Dirección predeterminada
            $table->boolean('es_predeterminada')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};