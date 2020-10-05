<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use Livewire\Component;

class ThreadSidebar extends Component
{
    public $thread;

    public $subscribedState;

    protected $listeners = ['refresh'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->subscribedState = $thread->isSubscribed;
    }

    public function subscribe()
    {
        if (auth()->guest()) {
            return;
        }

        if ($this->thread->isSubscribed) {
            $this->thread->unsubscribe();

            $this->subscribedState = false;
    
            $this->emit('flash', 'unsubscribed to a thread');
        } else {
            $this->thread->subscribe();

            $this->subscribedState = true;
    
            $this->emit('flash', 'subscribed to a thread');
        }
    }

    public function refresh()
    {
        return;
    }

    public function render()
    {
        return view('livewire.thread-sidebar');
    }
}
