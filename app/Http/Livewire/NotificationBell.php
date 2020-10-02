<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class NotificationBell extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function confirm(DatabaseNotification $notification)
    {
        $notification->markAsRead();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
