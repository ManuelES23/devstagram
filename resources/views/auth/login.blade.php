@extends('layouts.app')

@section('titulo')
    Inicia Sesión en DevStagram
@endsection

@section('contenido')
    <div class="flex justify-center mt-8">
    <div class="w-full md:w-7/12 lg:w-5/12 flex flex-col items-center bg-white shadow-xl rounded-3xl p-12 border border-gray-100 min-h-[420px]">
            <div class="w-44 h-44 flex-shrink-0 mb-8 flex items-center justify-center">
                <img src="{{ asset('img/login.jpg') }}" alt="Imagen login de usuarios" class="w-full h-full object-cover rounded-full border-4 border-blue-400 shadow-lg">
            </div>
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-lg" novalidate>
                @csrf

                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-2xl text-sm p-2 text-center">{{ session('mensaje') }}</p>
                @endif

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" placeholder="Tu Email de Registro" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Tu Password de Registro" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label class="text-gray-500 font-normal text-sm" for="remember">Recordar mis credenciales</label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white font-bold py-2 px-4 rounded-full shadow-lg hover:from-blue-600 hover:via-indigo-700 hover:to-purple-700 transition-all duration-300 ring-2 ring-blue-200 hover:ring-purple-300 focus:outline-none focus:ring-4 focus:ring-indigo-300 uppercase">Iniciar Sesión</button>
            </form>
        </div>
    </div>
@endsection