<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        // Given we have a user, JohnDoe, who is signed in.
        $john = create('User', ['name' => 'JohnDoe']);

        $this->signIn($john);

        // And we also have a user, JaneDoe.
        $jane = create('User', ['name' => 'JaneDoe']);

        // If we have a thread
        $thread = create('Thread');

        // And JohnDoe replies to that thread and mentions @JaneDoe.
        $reply = make('Reply', [
            'body' => 'Hey @JaneDoe check this out.'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then @JaneDoe should receive a notification.
        $this->assertCount(1, $jane->notifications);
    }
}
