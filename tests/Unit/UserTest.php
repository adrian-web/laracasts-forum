<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function an_authenticated_user_can_check_if_he_read_all_replies_to_a_thread()
    {
        $this->signIn();

        $thread = create('Thread');

        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($user->hasSeenUpdatesFor($thread));

            $user->read($thread);

            $this->assertFalse($user->hasSeenUpdatesFor($thread));
        });
    }

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('User');

        $reply = create('Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastCreated('reply')->id);
    }
    
    /** @test */
    public function a_user_can_fetch_their_most_recent_thread()
    {
        $user = create('User');

        $thread = create('Thread', ['user_id' => $user->id]);

        $this->assertEquals($thread->id, $user->lastCreated('thread')->id);
    }
}
