
@extends('layouts.app')

@section('titulo')
    Editar Perfil : {{ Auth::user()->username }}
@endsection

@section('contenido')
    <div class="flex justify-center mt-8">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center bg-white shadow-xl rounded-3xl p-8 border border-gray-100">
            <div class="w-32 h-32 flex-shrink-0 mb-4">
                <img src="{{ Auth::user()->imagen ? asset('perfiles/' . Auth::user()->imagen) : asset('img/usuario.svg') }}" alt="Avatar usuario" class="w-full h-full object-cover rounded-full border-4 border-blue-400 shadow-lg">
            </div>
            <form action="{{ route('perfil.store') }}" method="POST" class="w-full" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-bold mb-2">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" placeholder="Tu Nombre de Usuario" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('username') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="imagen" class="block text-gray-700 font-bold mb-2">Imagen de Perfil</label>
                    <input type="file" id="imagen" name="imagen" accept=".jpg, .jpeg, .png"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 ">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white font-bold py-2 px-4 rounded-full shadow-lg hover:from-blue-600 hover:via-indigo-700 hover:to-purple-700 transition-all duration-300 ring-2 ring-blue-200 hover:ring-purple-300 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
@endsection