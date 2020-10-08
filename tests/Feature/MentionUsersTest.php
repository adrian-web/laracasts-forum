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
        $john = create('User', ['username' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create('User', ['username' => 'JaneDoe']);

        $thread = create('Thread');

        $thread->replies()->create([
            'body' => 'Hey @JaneDoe.',
            'user_id' => auth()->id(),
        ]);

        // $thread = create('Thread');

        // $reply = make('Reply', [
        //     'body' => 'Hey @JaneDoe check this out.'
        // ]);

        // $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
