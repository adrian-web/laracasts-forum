<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use Livewire\Component;

class CreateReply extends Component
{
    public $thread;

    public $body;

    protected $rules = [
        'body' => 'required',
    ];

    public function mount(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function create()
    {
        if (auth()->guest()) {
            return;
        }

        $this->validate();

        $this->thread->replies()->create([
            'body' => $this->body,
            'user_id' => auth()->id(),
        ]);

        $this->emit('refresh');

        $this->emit('flash', 'created a reply');

        $this->body = '';
    }

    public function render()
    {
        return view('livewire.create-reply');
    }
}
