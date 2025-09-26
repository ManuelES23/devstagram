<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request) {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        $uploadsPath = public_path('uploads');

        // Verificar si la carpeta existe, si no, crearla
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0755, true);
        }

        $imagenServidor = Image::read($imagen);
        $imagenServidor->cover(1000,1000);

        $imagePath = $uploadsPath . '/' . $nombreImagen;
        $imagenServidor->save($imagePath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}