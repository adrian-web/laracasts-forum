<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $thread->replies()->create([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        
        $this->validate(request(), [
            'body' => 'required'
        ]);

        dd(request());

        $reply->update(request(['body']));
    }
}
