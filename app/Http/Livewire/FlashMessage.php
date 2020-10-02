<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message = null;

    public $shown = false;

    protected function getListeners()
    {
        return ['flash'];
    }

    public function flash($message)
    {
        $this->message = 'Success! You ' . $message . '.';

        $this->shown = true;
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
