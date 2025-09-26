@extends('layouts.app')

@section('titulo')
Inicio
@endsection

@section('contenido')
<div class="flex flex-col md:flex-row gap-8">
    <!-- Barra lateral izquierda: Perfil -->
    <aside class="hidden md:block md:w-1/4 lg:w-1/5">
        <div class="bg-white rounded-2xl shadow p-6 mb-6 text-center">
            <img class="w-24 h-24 rounded-full mx-auto mb-3 border-4 border-blue-200 object-cover" src="{{ asset('perfiles/' . (auth()->user()->imagen ?? 'usuario.svg')) }}" alt="Perfil">
            <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->username }}</h2>
            <p class="text-gray-500 text-sm">{{ auth()->user()->name }}</p>
            <a href="{{ route('perfil.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Editar perfil</a>
        </div>
        <!-- Sugerencias de usuarios -->
        <div class="bg-white rounded-2xl shadow p-4">
            <h3 class="font-semibold text-gray-700 mb-3">Sugerencias para ti</h3>
            <!-- Aquí podrías iterar sobre sugerencias -->
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ asset('img/usuario.svg') }}" class="w-8 h-8 rounded-full" alt="">
                <div>
                    <p class="text-sm font-medium text-gray-800">usuario_demo</p>
                    <button class="text-xs text-blue-500 hover:underline">Seguir</button>
                </div>
            </div>
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ asset('img/usuario.svg') }}" class="w-8 h-8 rounded-full" alt="">
                <div>
                    <p class="text-sm font-medium text-gray-800">ejemplo123</p>
                    <button class="text-xs text-blue-500 hover:underline">Seguir</button>
                </div>
            </div>
            <div class="text-xs text-gray-400 mt-4">Ver más sugerencias</div>
        </div>
    </aside>

    <!-- Feed central -->
    <main class="flex-1">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Feed</h1>
        </div>
        <x-listar-post :posts="$posts"/>
    </main>

    <!-- Barra lateral derecha (opcional, para anuncios o tendencias) -->
    <aside class="hidden lg:block lg:w-1/5">
        <div class="bg-white rounded-2xl shadow p-4 mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Tendencias</h3>
            <ul class="text-sm text-gray-600">
                <li>#Laravel</li>
                <li>#PHP</li>
                <li>#Devstagram</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
            <h3 class="font-semibold text-gray-700 mb-2">Publicidad</h3>
            <div class="text-xs text-gray-400">Tu anuncio aquí</div>
        </div>
    </aside>
</div>
@endsection