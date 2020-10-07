<?php

namespace App\Models;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\Traits\Favorable;
use App\Traits\NotifySubscriber;
use App\Traits\RecordActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

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
            event(new ThreadReceivedNewReply($reply));
        });

        static::updated(function ($reply) {
            event(new ThreadReceivedNewReply($reply));
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
        return $this->created_at > Carbon::now()->subSeconds(15);
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function notifyMentionedUsers(): void
    {
        $users = User::whereIn('username', $this->mentionedUsers())->get();
        Notification::send($users, new YouWereMentioned($this));
    }

    public function displayMentionedUsers()
    {
        $users = User::whereIn('username', $this->mentionedUsers())->get();
        
        $body = $this->body;

        foreach ($users as $user) {
            $body = str_ireplace("@" . ($user->toArray())["username"], "<a href=\"" . $user->path() . "\" class=\"hover:underline\">@" . ($user->toArray())["username"] . "</a>", $body);
        }

        return $body;
    }
}
