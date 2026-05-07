<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
{
    Admin::firstOrCreate(
        ['email' => 'admin@elenex.com'],
        [
            'nombre'   => 'Administrador Principal',
            'password' => Hash::make('Elenex2024$'),
        ]
    );
}
}