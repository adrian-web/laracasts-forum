<?php

namespace App\Http\Livewire;

use App\Models\Thread;
use App\Rules\Spamfree;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CreateThread extends Component
{
    use AuthorizesRequests;

    public $channel_id;

    public $title;

    public $body;

    public $classes;

    public $confirmingThreadCreation = false;

    public function mount($classes)
    {
        $this->classes = $classes;
    }

    public function create()
    {
        if (\Gate::denies('create', new Thread)) {
            return $this->emitTo('FlashMessage', 'flash', 'You are posting too frequently', 'red');
        }

        $this->validate([
            'title' => ['required', new Spamfree],
            'body' => ['required', new Spamfree],
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create(
            [
                'user_id' => auth()->id(),
                'channel_id' => $this->channel_id,
                'title' => $this->title,
                'body' => $this->body,
            ]
        );

        return redirect($thread->path());
    }

    public function render()
    {
        return view('livewire.create-thread');
    }
}
