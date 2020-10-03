<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    function an_authenticated_user_can_check_if_he_read_all_replies_to_a_thread()
    {
        $this->signIn();

        $thread = create('Thread');

        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($user->hasSeenUpdatesFor($thread));

            $user->read($thread);

            $this->assertFalse($user->hasSeenUpdatesFor($thread));
        });
    }
}
