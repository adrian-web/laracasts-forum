<?php

namespace App\Http\Livewire;

use App\Models\Reply;
use App\Rules\Spamfree;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ManageReply extends Component
{
    use AuthorizesRequests;

    public $reply;

    public $body;

    public $bodyCache;

    public $favoriteCount;

    public $favoriteState;

    protected $listeners = ['lock' => '$refresh', 'unlock' => '$refresh'];

    public function mount(Reply $reply)
    {
        $this->reply = $reply;

        $this->body = $reply->body;

        $this->bodyCache = $reply->body;

        $this->favoriteCount = $reply->favorites_count;

        $this->favoriteState = $reply->isFavorited;
    }

    public function update()
    {
        if ($this->reply->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }
        
        $this->authorize('update', $this->reply);
        
        $this->validate([
            'body' => ['required', new Spamfree],
        ]);

        $this->reply->update([
            'body' => $this->body
        ]);

        $this->emit('flash', 'updated a reply');

        $this->bodyCache = $this->body;
    }

    public function delete()
    {
        if ($this->reply->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }

        $this->authorize('delete', $this->reply);

        $this->reply->delete();

        $this->emit('refresh');

        $this->emitTo('FlashMessage', 'flash', 'deleted a reply');
    }

    public function favorite()
    {
        if ($this->reply->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }

        if ($this->reply->isFavorited) {
            $this->reply->unfavorite();
            
            $this->emitTo('FlashMessage', 'flash', 'unliked a reply');

            $this->favoriteCount = $this->reply->favorites_count;
                        
            $this->favoriteState = false;

            $this->favoriteCount--;
        } else {
            $this->reply->favorite();
            
            $this->emitTo('FlashMessage', 'flash', 'liked a reply');

            $this->favoriteCount = $this->reply->favorites_count;

            $this->favoriteState = true;

            $this->favoriteCount++;
        }
    }

    public function best()
    {
        if ($this->reply->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }

        $this->authorize('update', $this->reply->thread);

        if ($this->reply->thread->best_reply_id == $this->reply->id) {
            $this->reply->thread->update([
                'best_reply_id' => null
            ]);

            $this->emitTo('FlashMessage', 'flash', 'unmarked the best reply');
        } else {
            $this->reply->thread->update([
                'best_reply_id' => $this->reply->id
            ]);

            $this->emitTo('FlashMessage', 'flash', 'marked the best reply');
        }
    }

    public function return()
    {
        $this->body = $this->bodyCache;
    }

    public function render()
    {
        return view('livewire.manage-reply');
    }
}
