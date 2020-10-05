<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Rules\Spamfree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel, Thread $thread)
    {
        if (Gate::denies('create', new Reply)) {
            return response(
                'You are posting too frequently.',
                429
            );
        }

        $this->validate(request(), [
            'body' => ['required', new Spamfree]
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
            'body' => ['required', new Spamfree]
        ]);

        $reply->update(request(['body']));
    }
}
