<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use Livewire\Component;
use Livewire\WithPagination;

class ShowThread extends Component
{
    use WithPagination;

    public $thread;

    protected $listeners = ['refresh'];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function refresh()
    {
        return;
    }

    public function render()
    {
        return view('livewire.show-thread', [
            'replies' => $this->thread->replies()->paginate(5)
        ]);
    }
}
