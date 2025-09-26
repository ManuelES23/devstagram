<div>
    <button type="submit" class="group focus:outline-none flex flex-col items-start" wire:click="like">
        <span class="relative flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-10 w-10 {{ $isLiked ? 'fill-pink-400' : 'fill-gray-400' }} group-hover:scale-110 transition-transform drop-shadow-lg"
                viewBox="0 0 20 20">
                <path
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
            </svg>
            <span class="text-sm text-gray-700">{{ $post->likes->count() }} Me gusta</span>
            
        </span>
    </button>
</div>
