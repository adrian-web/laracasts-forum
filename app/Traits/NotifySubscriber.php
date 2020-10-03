<?php

namespace App\Traits;

use App\Notifications\ReplyNotification;

trait NotifySubscriber
{
    protected static function bootNotifySubscriber()
    {
        // if (auth()->guest()) {
        //     return;
        // }

        foreach (static::getEventsToNotify() as $event) {
            static::$event(function ($model) use ($event) {
                $model->notifySubscriber($event);
            });
        }
    }
    
    protected static function getEventsToNotify()
    {
        return ['created'];
    }

    protected function notifySubscriber($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        if ($type == 'reply') {
            // foreach ($this->thread->subscriptions as $subscription) {
            //     if ($subscription->subscriber->id != $this->user_id) {
            //         $subscription->subscriber->notify(new ReplyNotification($this, $event));
            //     }
            // }
            
            $this->thread->subscriptions->filter(function ($subscription) {
                return $subscription->subscriber->id != $this->user_id;
            })->each(function ($subscription) use ($event) {
                $subscription->subscriber->notify(new ReplyNotification($this, $event));
            });
        }
    }
}
