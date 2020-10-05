<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\NotifySubscriber;
use App\Traits\RecordActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    use Favorable;
    use RecordActivity;
    use NotifySubscriber;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $withCount = ['favorites'];

    protected $appends = ['isFavorited'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->touch();
            $reply->owner->read($reply->thread);
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path();
    }

    public function wasJustCreated()
    {
        return $this->created_at > Carbon::now()->subMinute();
    }
}
