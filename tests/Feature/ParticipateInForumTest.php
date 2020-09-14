<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function unauthenticated_user_may_not_add_a_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
              
        $this->withoutExceptionHandling();
                
        $thread = Thread::factory()->create();

        $reply = Reply::factory()->make();

        $this->post($thread->path() . '/replies', $reply->toArray());
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
    
        $thread = Thread::factory()->create();

        $reply = Reply::factory()->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
                ->assertSee($reply->body);
    }
}