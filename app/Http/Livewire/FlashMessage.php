<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message = null;

    public $color = null;

    public $shown = false;

    protected function getListeners()
    {
        return ['flash', 'hide'];
    }

    public function flash($message, $color = 'green')
    {
        $this->message = $message;

        $this->color = $color;

        $this->shown = true;

        $this->emit('auto');
    }

    public function hide()
    {
        $this->shown = false;
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
