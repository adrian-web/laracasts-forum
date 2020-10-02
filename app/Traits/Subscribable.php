<?php

namespace App\Traits;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

trait Subscribable
{
    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribed');
    }

    public function subscribe()
    {
        if (auth()->guest()) {
            return;
        }

        $attributes = ['user_id' => auth()->id()];

        if (! $this->subscriptions()->where($attributes)->exists()) {
            return $this->subscriptions()->create($attributes);
        }
    }

    public function unsubscribe()
    {
        if (auth()->guest()) {
            return;
        }

        $attributes = ['user_id' => auth()->id()];

        $this->subscriptions()->where($attributes)->get()->each->delete();
    }

    public function isSubscribed()
    {
        return !! $this->subscriptions->where('user_id', auth()->id())->count();
    }

    public function getIsSubscribedAttribute()
    {
        return $this->isSubscribed();
    }
}
