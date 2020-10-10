<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use App\Rules\Spamfree;
use Livewire\Component;

class CreateReply extends Component
{
    public $thread;

    public $body;

    public $lockState;

    protected $listeners = ['lock', 'unlock'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->lockState = $thread->locked;
    }

    public function create()
    {
        if ($this->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        }

        if (auth()->guest()) {
            return redirect('login');
        }

        if (\Gate::denies('create-throttle', 'Reply')) {
            return $this->emitTo('FlashMessage', 'flash', 'You are posting too frequently', 'red');
        }

        $this->validate([
            'body' => ['required', new Spamfree],
        ]);

        $this->thread->replies()->create([
            'body' => $this->body,
            'user_id' => auth()->id(),
        ]);

        $this->emit('refresh');

        $this->emitTo('FlashMessage', 'flash', 'created a reply');

        $this->body = '';
    }

    public function lock()
    {
        $this->lockState = true;
    }

    public function unlock()
    {
        $this->lockState = false;
    }

    public function render()
    {
        return view('livewire.create-reply');
    }
}
