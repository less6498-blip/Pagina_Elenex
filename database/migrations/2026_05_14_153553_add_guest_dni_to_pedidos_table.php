<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->string('guest_dni', 8)->nullable()->after('guest_telefono');
    });
}

public function down(): void
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->dropColumn('guest_dni');
    });
}
};
