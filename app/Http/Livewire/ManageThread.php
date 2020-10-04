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

    public $bodyReply;

    public $subscribedState;

    public $editState = false;

    public $bodyCache;

    public $titleCache;

    public $confirmingThreadDeletion = false;

    protected $rules = [
        'thread.title' => 'required',
        'thread.body' => 'required',
    ];

    protected $listeners = ['deleted' => 'resetPagination', 'created' => 'resetPagination'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->bodyCache = $thread->body;

        $this->titleCache = $thread->title;

        $this->subscribedState = $thread->isSubscribed;
    }

    public function createReply()
    {
        if (auth()->guest()) {
            return;
        }

        $this->validate([
            'bodyReply' => 'required'
        ]);

        $this->thread->replies()->create([
            'body' => $this->bodyReply,
            'user_id' => auth()->id()
        ]);

        $this->emitSelf('created');

        $this->emit('flash', 'created a reply');

        $this->bodyReply = '';
    }

    public function delete()
    {
        $this->authorize('delete', $this->thread);

        $this->thread->delete();

        $this->emit('flash', 'deleted a thread');

        return redirect()->route('threads');
    }

    public function update()
    {
        $this->authorize('update', $this->thread);
        
        $this->validate();
        
        $this->thread->update();

        $this->emit('flash', 'updated a thread');

        $this->editState = false;

        $this->bodyCache = $this->thread->body;

        $this->titleCache = $this->thread->title;
    }

    public function return()
    {
        $this->editState = false;

        $this->thread->body = $this->bodyCache;

        $this->thread->title = $this->titleCache;
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
