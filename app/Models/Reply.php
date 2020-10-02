<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\NotifySubscriber;
use App\Traits\RecordActivity;
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
}
