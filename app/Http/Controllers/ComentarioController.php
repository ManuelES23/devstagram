<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        $validated = $request->validate([
            'comentario' => 'required|max:255',
        ]);

        Comentario::create([
            ...$validated,
            'post_id' => $post->id,
            'user_id' => Auth::user()->id
        ]);

        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }
}