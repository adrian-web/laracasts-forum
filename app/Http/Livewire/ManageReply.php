<?php

namespace App\Http\Livewire;

use App\Models\Reply;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ManageReply extends Component
{
    use AuthorizesRequests;

    public $reply;

    public $editState = false;

    public $bodyCache;

    public $favoriteState;

    protected $rules = [
        'reply.body' => 'required',
    ];

    public function mount(Reply $reply)
    {
        $this->reply = $reply;

        $this->bodyCache = $reply->body;

        $this->favoriteState = $reply->isFavorited;
    }

    public function update()
    {
        $this->authorize('update', $this->reply);
        
        $this->validate();
        
        $this->reply->update();

        $this->emit('flash', 'updated a reply');

        $this->editState = false;

        $this->bodyCache = $this->reply->body;
    }

    public function delete()
    {
        $this->authorize('delete', $this->reply);

        $this->reply->delete();

        $this->emitUp('deleted');

        $this->emit('flash', 'deleted a reply');
    }

    public function favorite()
    {
        if (auth()->guest()) {
            return;
        }

        if ($this->reply->isFavorited) {
            $this->reply->unfavorite();
            
            $this->emit('flash', 'unliked a reply');
            
            $this->reply->favorites_count--;
            
            $this->favoriteState = false;
        } else {
            $this->reply->favorite();
            
            $this->emit('flash', 'liked a reply');

            $this->reply->favorites_count++;

            $this->favoriteState = true;
        }
    }

    public function return()
    {
        $this->editState = false;

        $this->reply->body = $this->bodyCache;
    }

    public function render()
    {
        return view('livewire.manage-reply');
    }
}
