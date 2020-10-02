<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class ManageThread extends Component
{
    use AuthorizesRequests;

    use WithPagination;

    public $thread;

    public $body;

    public $subscribedState;

    protected $rules = [
        'body' => 'required',
    ];

    protected $listeners = ['deleted' => 'resetPagination', 'created' => 'resetPagination'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->subscribedState = $thread->isSubscribed;
    }

    public function create()
    {
        if (auth()->guest()) {
            return;
        }

        $this->validate();

        $this->thread->replies()->create([
            'body' => $this->body,
            'user_id' => auth()->id()
        ]);

        $this->emitSelf('created');

        $this->emit('flash', 'created a reply');

        $this->body = '';
    }

    public function delete()
    {
        $this->authorize('delete', $this->thread);

        $this->thread->delete();

        $this->emit('flash', 'deleted a thread');

        return redirect()->route('threads');
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

    public function resetPagination()
    {
        // $this->resetPage();
    }

    public function render()
    {
        return view('livewire.manage-thread', [
            'replies' => $this->thread->replies()->paginate(5)
        ]);
    }
}
