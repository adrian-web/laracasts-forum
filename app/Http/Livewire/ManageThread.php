<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use App\Models\Trending;
use App\Rules\Spamfree;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ManageThread extends Component
{
    use AuthorizesRequests;

    public $thread;

    public $body;

    public $title;

    public $bodyCache;

    public $titleCache;

    public $confirmingThreadDeletion = false;

    protected $listeners = ['lock' => '$refresh', 'unlock' => '$refresh'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->body = $thread->body;

        $this->title = $thread->title;

        $this->bodyCache = $thread->body;

        $this->titleCache = $thread->title;
    }

    public function delete()
    {
        if ($this->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }
        
        $this->authorize('delete', $this->thread);

        (new Trending)->destroy($this->thread);

        $this->thread->delete();

        // flash-message.blade.php disapears on redirect
        // $this->emitTo('FlashMessage', 'flash', 'deleted a thread');
        
        return redirect()->route('forum');
    }

    public function update()
    {
        if ($this->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }

        $this->authorize('update', $this->thread);
        
        $this->validate([
            'body' => ['required', new Spamfree],
            'title' => ['required', new Spamfree],
        ]);

        $this->thread->update([
            'body' => $this->body,
            'title' => $this->title,
        ]);

        $this->emitTo('FlashMessage', 'flash', 'updated a thread');

        $this->bodyCache = $this->body;

        $this->titleCache = $this->title;
    }

    public function return()
    {
        $this->body = $this->bodyCache;

        $this->title = $this->titleCache;
    }

    public function render()
    {
        return view('livewire.manage-thread');
    }
}
