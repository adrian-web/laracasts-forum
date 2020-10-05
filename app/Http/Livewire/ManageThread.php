<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use App\Rules\Spamfree;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ManageThread extends Component
{
    use AuthorizesRequests;

    public $thread;

    public $editState = false;

    public $body;

    public $title;

    public $bodyCache;

    public $titleCache;

    public $confirmingThreadDeletion = false;

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
        $this->authorize('delete', $this->thread);

        $this->thread->delete();

        $this->emitTo('FlashMessage', 'flash', 'deleted a thread');

        return redirect()->route('threads');
    }

    public function update()
    {
        $this->authorize('update', $this->thread);
        
        $this->validate([
            'body' => ['required', new Spamfree],
            'title' => ['required', new Spamfree],
        ]);

        $this->thread->update([
            'body' => $this->thread->body,
            'title' => $this->thread->title,
        ]);

        $this->emitTo('FlashMessage', 'flash', 'updated a thread');

        $this->editState = false;

        $this->bodyCache = $this->body;

        $this->titleCache = $this->title;
    }

    public function return()
    {
        $this->editState = false;

        $this->body = $this->bodyCache;

        $this->title = $this->titleCache;
    }

    public function render()
    {
        return view('livewire.manage-thread');
    }
}
