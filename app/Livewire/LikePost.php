<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    public function mount()
    {
        $this->isLiked = $this->post->checkLike(auth()->user());
        $this->likes = $this->post->likes()->count();
    }

    public function like() {
        if( $this->post->checkLike(auth()->user()) ) {
            // Eliminar solo el like del usuario autenticado
            $this->post->likes()
                ->where('post_id', $this->post->id)
                ->where('user_id', auth()->user()->id)
                ->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            // Agregar el like
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }

        // Actualizar la cantidad de likes
        $this->post = $this->post->fresh();
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}