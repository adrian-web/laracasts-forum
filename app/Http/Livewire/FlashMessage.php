<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message = null;

    public $color = null;

    public $state = false;

    protected $listeners = ['flash'];

    public function flash($message, $color = 'green')
    {
        $this->message = $message;

        $this->color = $color;

        $this->state = ! $this->state;
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
