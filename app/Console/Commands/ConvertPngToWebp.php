<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertPngToWebp extends Command
{
    protected $signature = 'images:convert-webp';
    protected $description = 'Convertir imágenes PNG a WebP, actualizar BD y borrar PNG originales';

    public function handle()
    {
        $productos = DB::table('productos')->get();

        foreach ($productos as $producto) {
            $currentFile = $producto->imagen;

            // Procesar solo PNG
            if (!preg_match('/\.png$/i', $currentFile)) {
                $this->info("Saltando {$currentFile} (no es PNG)");
                continue;
            }

            $pngPath = public_path('img/' . $currentFile);
            if (!file_exists($pngPath)) {
                $this->warn("Archivo no encontrado: {$currentFile}");
                continue;
            }

            $webpPath = preg_replace('/\.png$/i', '.webp', $pngPath);

            // Crear WebP
            $img = imagecreatefrompng($pngPath);
            if ($img === false) {
                $this->warn("No se pudo procesar {$currentFile}");
                continue;
            }

            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            imagewebp($img, $webpPath, 80);
            imagedestroy($img);

            // Actualizar BD
            $newName = basename($webpPath);
            DB::table('productos')
                ->where('id', $producto->id)
                ->update(['imagen' => $newName]);

            // Borrar PNG original
            unlink($pngPath);

            $this->info("Convertido: {$currentFile} → $newName");
        }

        $this->info("¡Conversión finalizada!");
    }
}