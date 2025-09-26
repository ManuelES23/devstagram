<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;
    //
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // dd($request);

        $request->merge(['username' => Str::slug($request->username)]);

        // Validación
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:15',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);
        // Insert a la base de datos
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Autenticar al usuario
        // Auth::attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        Auth::attempt($request->only('email', 'password'));

        // Redirection
        return redirect()->route('post.index', Auth::user()->username);
    }
}
