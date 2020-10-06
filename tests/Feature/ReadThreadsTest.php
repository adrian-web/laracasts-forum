<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = create('Thread');

        $this->get('/threads')
                ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $thread = create('Thread');

        $this->get($thread->path())
                ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $thread = create('Thread');

        $reply = create('Reply', ['thread_id' => $thread->id]);

        $this->get($thread->path())
                ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('Channel');

        $threadInChannel = create('Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('Thread');
    
        $this->get('/threads/' . $channel->slug)
                ->assertSee($threadInChannel->title)
                ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_a_user_name()
    {
        $user = create('User', ['username' => 'janek']);
        $this->signIn($user);

        $threadByJanek = create('Thread', ['user_id' => $user->id]);
        $threadNotByJanek = create('Thread');

        $this->get('/threads?by=janek')
                ->assertSee($threadByJanek->title)
                ->assertDontSee($threadNotByJanek->title);
    }
    
    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('Thread');
        create('Reply', ['created_at' => new Carbon('-2 minute'),
                        'thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('Thread');
        create('Reply', ['created_at' => new Carbon('-1 minute'),
                        'thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = create('Thread');

        $response = $this->get('threads?popular=1');

        $response->assertSeeInOrder([
            $threadWithThreeReplies->title,
            $threadWithTwoReplies->title,
            $threadWithNoReplies->title
        ]);
    }

    /** @test */
    public function a_user_can_filter_by_unanswered_threads()
    {
        $threadWithoutReply = create('Thread');

        $threadWithReply = create('Thread');
        create('Reply', ['thread_id' => $threadWithReply->id]);

        $this->get('threads?unanswered=1')
                ->assertSee($threadWithoutReply->title)
                ->assertDontSee($threadWithReply->title);
    }
}
