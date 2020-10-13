<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use Livewire\Component;

class ThreadSidebar extends Component
{
    public $thread;

    public $subscribedState;

    public $lockedState;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->subscribedState = $thread->isSubscribed;

        $this->lockedState = $thread->locked;
    }

    public function lock()
    {
        if (auth()->guest()) {
            return redirect('login');
        } elseif (! auth()->user()->isAdmin()) {
            return $this->emitTo('FlashMessage', 'flash', 'You\'re not an administrator', 'red');
        }

        if ($this->thread->locked) {
            $this->thread->update([
                'locked' => false
            ]);

            $this->emit('unlock');

            $this->emitTo('FlashMessage', 'flash', 'unlocked a thread');

            $this->lockedState = false;
        } else {
            $this->thread->update([
                'locked' => true
            ]);

            $this->emit('lock');

            $this->emitTo('FlashMessage', 'flash', 'locked a thread');

            $this->lockedState = true;
        }
    }

    public function subscribe()
    {
        if ($this->thread->locked) {
            return $this->emitTo('FlashMessage', 'flash', 'thread is locked', 'red');
        } elseif (auth()->guest()) {
            return redirect('login');
        }

        if ($this->thread->isSubscribed) {
            $this->thread->unsubscribe();

            $this->subscribedState = false;
    
            $this->emitTo('FlashMessage', 'flash', 'unsubscribed to a thread');
        } else {
            $this->thread->subscribe();

            $this->subscribedState = true;
    
            $this->emitTo('FlashMessage', 'flash', 'subscribed to a thread');
        }
    }

    public function render()
    {
        return view('livewire.thread-sidebar');
    }
}
