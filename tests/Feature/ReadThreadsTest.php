<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->withoutExceptionHandling();

        $thread = Thread::factory()->create();

        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        // $this->withoutExceptionHandling();

        $thread = Thread::factory()->create();

        $response = $this->get($thread->path());
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // $this->withoutExceptionHandling();

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $response = $this->get($thread->path());

        $response->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $this->withoutExceptionHandling();

        $channel = Channel::factory()->create();

        $threadInChannel = Thread::factory()->create(['channel_id' => $channel->id]);
        $threadNotInChannel = Thread::factory()->create();
    
        $this->get('/threads/' . $channel->slug)
                ->assertSee($threadInChannel->title)
                ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_a_user_name()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['name' => 'Janek']);
        $this->actingAs($user);

        $threadByJanek = Thread::factory()->create(['owner_id' => $user->id]);
        $threadNotByJanek = Thread::factory()->create();

        $this->get('/threads?by=Janek')
                ->assertSee($threadByJanek->title)
                ->assertDontSee($threadNotByJanek->title);
    }
}
