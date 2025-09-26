<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //Modificar el request
        $request->merge(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => [ 'required', 'max:20', 'unique:users,username,' . auth()->user()->id, 'min:3', 'not_in:editar-perfil,twitter'],
        ]);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            $perfilesPath = public_path('perfiles');

            // Verificar si la carpeta existe, si no, crearla
            if (!file_exists($perfilesPath)) {
                mkdir($perfilesPath, 0755, true);
            }

            // Eliminar imagen anterior si existe
            $usuarioActual = auth()->user();
            if ($usuarioActual->imagen) {
                $imagenAnteriorPath = $perfilesPath . '/' . $usuarioActual->imagen;
                if (file_exists($imagenAnteriorPath)) {
                    unlink($imagenAnteriorPath);
                }
            }

            // Intervention Image 3 usa Image::read() para cargar imágenes
            $imagenServidor = Image::read($imagen->getRealPath());
            $imagenServidor = $imagenServidor->cover(1000, 1000);

            $imagePath = $perfilesPath . '/' . $nombreImagen;
            $imagenServidor->save($imagePath);

            $nombreImagen = basename($imagePath);
        }

        // Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route('post.index', $usuario->username);
    }
}