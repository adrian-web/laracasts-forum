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

    public $editState = false;

    public $deleteState = false;

    public $body;

    public $bodyCache;

    public $favoriteCount;

    public $favoriteState;

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
        if (auth()->guest()) {
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

        $this->editState = false;

        $this->bodyCache = $this->body;
    }

    public function delete()
    {
        if (auth()->guest()) {
            return redirect('login');
        }

        $this->authorize('delete', $this->reply);

        $this->reply->delete();

        $this->emit('refresh');

        $this->emitTo('FlashMessage', 'flash', 'deleted a reply');
    }

    public function favorite()
    {
        if (auth()->guest()) {
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
        if (auth()->guest()) {
            return redirect('login');
        }

        $this->authorize('update', $this->reply->thread);

        if ($this->reply->thread->best_reply_id == $this->reply->id) {
            $this->emit('best', $this->reply->thread->best_reply_id, null);

            $this->reply->thread->unmarkBestReply();

            $this->emitTo('FlashMessage', 'flash', 'unmarked the best reply');
        } else {
            $this->emit('best', $this->reply->thread->best_reply_id, $this->reply->id);

            $this->reply->thread->markBestReply($this->reply);

            $this->emitTo('FlashMessage', 'flash', 'marked the best reply');
        }
    }

    public function return()
    {
        $this->editState = false;

        $this->body = $this->bodyCache;
    }

    public function render()
    {
        return view('livewire.manage-reply');
    }
}
