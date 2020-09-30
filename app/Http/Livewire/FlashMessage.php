<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message;

    public $shown = false;

    protected function getListeners()
    {
        return ['flash'];
    }

    public function flash($message)
    {
        $this->message = 'Success! You ' . $message . ' a reply.';

        $this->shown = true;
    }

    public function hide()
    {
        $this->message = null;

        $this->shown = false;
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
