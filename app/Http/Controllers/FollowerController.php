<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        // Almacenar el seguidor
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    public function destroy(User $user)
    {
        // Eliminar el seguidor
        $user->followers()->detach(auth()->user()->id);

        return back();
    }
}