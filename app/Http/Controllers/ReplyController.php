<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        $thread->replies()->create([
            'body' => request('body'),
            'owner_id' => auth()->id()
        ]);

        return back();
    }
}
