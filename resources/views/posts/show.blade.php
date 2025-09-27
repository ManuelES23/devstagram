@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto flex flex-col md:flex-row gap-10 py-10 px-4 items-start">
        <!-- Post Image & Info Glassmorphism -->

        <div
            class="w-full md:w-1/2 flex flex-col items-center bg-white/70 backdrop-blur-lg rounded-3xl shadow-2xl p-6 md:p-10 border border-blue-100 self-start h-auto md:h-[calc(100vh-200px)] transition-transform hover:scale-[1.01]">
            <img class="w-full h-96 object-cover rounded-2xl mb-6 shadow-2xl border-4 border-blue-200 hover:shadow-2xl transition"
                src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            <div class="w-full flex justify-start mb-4">
                @auth
                    <livewire:like-post :post="$post" />

                @endauth


            </div>
            <div class="w-full">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-gradient-to-br from-sky-100 to-blue-200 rounded-full p-2 shadow-lg">
                        @if ($post->user->imagen)
                            <img src="{{ asset('perfiles/' . $post->user->imagen) }}" alt="Avatar usuario"
                                class="w-9 h-9 rounded-full object-cover">
                        @else
                            <svg class="w-9 h-9 text-sky-600" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 3a3 3 0 110 6 3 3 0 010-6zm0 14a7 7 0 01-5.916-3.09c.032-1.97 3.944-3.06 5.916-3.06 1.972 0 5.884 1.09 5.916 3.06A7 7 0 0112 19z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-lg text-sky-700">{{ $post->user->username }}</p>
                        <p class="text-xs text-gray-400 flex items-center gap-1"><svg class="w-4 h-4 inline text-gray-300"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <p
                    class="mt-4 text-gray-700 text-base leading-relaxed border-l-4 border-blue-200 pl-4 bg-blue-50/60 py-2 rounded-xl shadow-inner">
                    {{ $post->descripcion }}
                </p>
                @auth
                    @if ($post->user_id === Auth::user()->id)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="Eliminar Publicación"
                                class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 p-2 rounded-2xl text-white font-bold mt-4 cursor-pointer shadow-lg">
                        </form>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Comments Section Glassmorphism -->
        <div
            class="w-full md:w-1/2 flex flex-col items-center bg-white/70 backdrop-blur-lg rounded-3xl shadow-2xl p-6 md:p-10 border border-blue-100 self-start h-auto md:h-[calc(100vh-200px)]">
            <div class="w-full">
                <p class="text-2xl font-extrabold text-center mb-6 text-sky-700 tracking-wide uppercase">Comentarios</p>
                <!-- Lista de comentarios -->
                <div class="flex-1 overflow-y-auto rounded-xl p-2 md:p-4 max-h-60 md:max-h-100">
                    @forelse ($post->comentarios as $comentario)
                        <div
                            class="p-4 mb-4 bg-gradient-to-br from-blue-50/80 to-white/80 rounded-xl border border-blue-100 shadow hover:shadow-lg transition flex gap-3 items-start">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-full bg-sky-200 flex items-center justify-center text-sky-700 font-bold text-lg shadow">
                                    @if ($comentario->user->imagen)
                                        <img src="{{ asset('perfiles/' . $comentario->user->imagen) }}" alt="Avatar"
                                            class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        {{ strtoupper(substr($comentario->user->username, 0, 1)) }}
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-2 mb-1">
                                    <a href="{{ route('post.index', $comentario->user) }}"
                                        class="font-bold text-sky-600 hover:underline">
                                        {{ $comentario->user->username }}
                                    </a>
                                    <span
                                        class="text-xs text-gray-400">{{ $comentario->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 break-words">{{ $comentario->comentario }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-gray-400">No hay comentarios aún.</p>
                    @endforelse
                </div>
                <!-- Formulario para añadir comentario -->
                <div class="mt-4 w-full">
                    @auth
                        @if (session('mensaje'))
                            <div class="bg-green-500 p-2 rounded-2xl mb-4 text-white uppercase font-bold text-center shadow-lg">
                                {{ session('mensaje') }}
                            </div>
                        @endif
                        <form action="{{ route('comentarios.store', ['post' => $post, 'user' => auth()->user()]) }}"
                            method="POST" class="flex flex-col gap-4 mt-5">
                            @csrf
                            <div class="relative">
                                <label for="comentario" class="mb-1 block uppercase text-gray-500 font-bold text-sm">Añade un
                                    comentario</label>
                                <textarea name="comentario" id="comentario" placeholder="Escribe tu comentario..."
                                    class="border p-3 w-full rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-sky-400 transition @error('comentario') border-red-500 @enderror pr-10"
                                    rows="3">{{ old('comentario') }}</textarea>
                                <svg class="absolute right-3 top-10 w-6 h-6 text-sky-300 pointer-events-none" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                @error('comentario')
                                    <p class="bg-red-500 text-white my-2 rounded-2xl text-sm p-2 text-center">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <input type="submit" value="Comentar"
                                class="bg-gradient-to-r from-sky-600 to-sky-400 hover:from-sky-700 hover:to-sky-500 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 shadow-xl">
                        </form>
                    @else
                        <p class="text-center text-gray-500 mb-2">Inicia sesión para comentar.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
