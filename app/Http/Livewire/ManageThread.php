<?php

namespace App\Http\Livewire;

use App\Models\Reply;
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

    protected $rules = [
        'body' => 'required',
    ];

    protected $listeners = ['deleted' => 'resetPagination', 'created' => 'resetPagination'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function create()
    {
        if (! auth()->check()) {
            return;
        }

        $this->validate();

        $this->thread->replies()->create([
            'body' => $this->body,
            'owner_id' => auth()->id()
        ]);

        $this->emitSelf('created');

        $this->body = '';
    }

    public function delete()
    {
        $this->authorize('delete', $this->thread);

        $this->thread->delete();

        return redirect()->route('threads');
    }

    public function resetPagination()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.manage-thread', [
            'replies' => $this->thread->replies()->paginate(3)
        ]);
    }
}
