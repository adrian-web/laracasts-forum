<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message = null;

    public $shown = false;

    protected function getListeners()
    {
        return ['flash', 'hide'];
    }

    public function flash($message)
    {
        $this->message = 'Success! You ' . $message . '.';

        $this->shown = true;

        $this->emit('auto');
    }

    public function hide()
    {
        $this->shown = false;

        $this->emit('clear');
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
