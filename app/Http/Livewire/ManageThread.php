<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ManageThread extends Component
{
    use AuthorizesRequests;

    public $thread;

    public $editState = false;

    public $bodyCache;

    public $titleCache;

    public $confirmingThreadDeletion = false;

    protected $rules = [
        'thread.title' => 'required',
        'thread.body' => 'required',
    ];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;

        $this->bodyCache = $thread->body;

        $this->titleCache = $thread->title;
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

        resolve(\App\Inspections\Spam::class)->detect($this->thread->body);
        resolve(\App\Inspections\Spam::class)->detect($this->thread->title);
        
        $this->thread->update([
            'body' => $this->thread->body,
            'title' => $this->thread->title,
        ]);

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

    public function render()
    {
        return view('livewire.manage-thread');
    }
}
