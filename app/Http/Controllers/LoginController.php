<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);



        if(!Auth::attempt($request->only('email', 'password'), $request->remember )) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        return redirect()->route('post.index', Auth::user()->username);

    }
}