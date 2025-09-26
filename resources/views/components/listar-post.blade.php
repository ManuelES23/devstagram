<div>
    @if ($posts->count())
            <div class="grid grid-cols-1 gap-8">
                @foreach ($posts as $post)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow border border-gray-100 flex flex-col">
                        <!-- Header usuario -->
                        <div class="flex items-center gap-3 p-4 border-b border-gray-100">
                            <img src="{{ asset('perfiles/' . ($post->user->imagen ?? 'usuario.svg')) }}" class="w-10 h-10 rounded-full" alt="">
                            <div>
                                <span class="font-semibold text-gray-800">{{ $post->user->username }}</span>
                                <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <!-- Imagen del post -->
                        <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                            <img class="w-full h-120 object-cover hover:scale-105 transition-transform duration-300" src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del Post {{ $post->titulo }}">
                        </a>
                        <!-- Contenido del post -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $post->titulo ?? 'Sin título' }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ $post->descripcion ?? '' }}</p>
                            <!-- Acciones: Like y contador -->
                            <div class="flex items-center gap-6 mb-2">
                                <livewire:like-post :post="$post" />
                            </div>
                            <!-- Comentarios (solo algunos) -->
                            <div class="mt-2">
                                @if ($post->comentarios->count())
                                    <div class="text-xs text-gray-500 mb-1">Comentarios recientes:</div>
                                    @foreach ($post->comentarios->take(2) as $comentario)
                                        <div class="mb-1">
                                            <span class="font-semibold text-gray-700">{{ $comentario->user->username }}:</span>
                                            <span>{{ $comentario->comentario }}</span>
                                        </div>
                                    @endforeach
                                    @if ($post->comentarios->count() > 2)
                                        <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}" class="text-xs text-blue-500 hover:underline">Ver todos los comentarios</a>
                                    @endif
                                @else
                                    <div class="text-xs text-gray-400">Sé el primero en comentar</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">No hay publicaciones aún.</div>
        @endif
</div>