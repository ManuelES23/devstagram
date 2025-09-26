@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center mt-8">
        <div
            class="w-full md:w-8/12 lg:w-6/12 flex flex-col md:flex-row items-center bg-white shadow-xl rounded-3xl p-8 border border-gray-100">
            <div class="w-32 h-32 flex-shrink-0 mb-4 md:mb-0 md:mr-8">
                <img src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                    alt="Avatar usuario" class="w-full h-full object-cover rounded-full border-4 border-blue-400 shadow-lg">
            </div>
            <div class="flex-1 flex flex-col items-center md:items-start text-center md:text-left">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-2">{{ $user->username }}</h2>
                <div class="flex gap-6 justify-center md:justify-start mb-4">
                    <div class="bg-blue-50 rounded-xl px-4 py-2 shadow hover:scale-105 transition-transform">
                        <span class="block text-xl font-bold text-blue-600">{{ $user->followers->count() }}</span>
                        <span class="text-xs text-gray-500">@choice('Seguidor|Seguidores', $user->followers->count())</span>
                    </div>
                    <div class="bg-blue-50 rounded-xl px-4 py-2 shadow hover:scale-105 transition-transform">
                        <span class="block text-xl font-bold text-blue-600">{{ $user->following->count() }}</span>
                        <span class="text-xs text-gray-500">Siguiendo</span>
                    </div>
                    <div class="bg-blue-50 rounded-xl px-4 py-2 shadow hover:scale-105 transition-transform">
                        <span class="block text-xl font-bold text-blue-600">{{ $user->posts->count() ?? 0 }}</span>
                        <span class="text-xs text-gray-500">Posts</span>
                    </div>
                    @auth
                        @if ($user->id !== auth()->user()->id)
                            <div class="flex gap-2">
                                @if (!$user->siguiendo(auth()->user()))
                                    <form action="{{ route('users.follow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white rounded-full font-bold shadow-lg hover:from-blue-600 hover:via-indigo-700 hover:to-purple-700 transition-all duration-300 ring-2 ring-blue-200 hover:ring-purple-300 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-6 4a4 4 0 100-8 4 4 0 000 8zm0 0v1a2 2 0 002 2h4a2 2 0 002-2v-1" />
                                            </svg>
                                            Seguir
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-full font-bold shadow hover:bg-gray-300 hover:text-gray-900 border border-gray-300 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Dejar de Seguir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth

                </div>
                @auth
                    @if (auth()->user()->id === $user->id)
                        <a href="{{ route('perfil.index') }}"
                            class="mt-2 inline-flex items-center gap-2 px-7 py-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white rounded-full font-bold shadow-lg hover:from-blue-600 hover:via-indigo-700 hover:to-purple-700 transition-all duration-300 ring-2 ring-blue-200 hover:ring-purple-300 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16.862 3.487a2.25 2.25 0 013.182 3.182l-12.5 12.5a2 2 0 01-.878.513l-3.25.93a.5.5 0 01-.62-.62l.93-3.25a2 2 0 01.513-.878l12.5-12.5z" />
                            </svg>
                            Editar Perfil
                        </a>
                    @endif

                @endauth

            </div>
        </div>
    </div>

    <section class="container mx-auto">
        <h2 class="text-4xl text-center font-black my-10 text-blue-700">Publicaciones</h2>
        <div class="w-full md:w-8/12 lg:w-6/12 mx-auto">
            <x-listar-post :posts="$posts" />
        </div>
    </section>
@endsection
