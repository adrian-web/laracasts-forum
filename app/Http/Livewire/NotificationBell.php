<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class NotificationBell extends Component
{
    public $unreadNotifications;

    public $unreadNotificationsUnique;

    public function mount(User $user)
    {
        $this->unreadNotifications = $user->unreadNotifications;
    }

    public function confirm(DatabaseNotification $unreadNotificationUnique)
    {
        $this->unreadNotifications->filter(function ($unreadNotification) use ($unreadNotificationUnique) {
            return $unreadNotification->data['link'] == $unreadNotificationUnique->data['link'];
        })->each(function ($unreadNotification) {
            return $unreadNotification->markAsRead();
        });

        return redirect($unreadNotificationUnique->data['link']);
    }

    public function render()
    {
        $this->unreadNotificationsUnique = tap($this->unreadNotifications->unique(function ($unreadNotification) {
            return $unreadNotification->data['link'];
        }))->values();

        return view('livewire.notification-bell');
    }
}
