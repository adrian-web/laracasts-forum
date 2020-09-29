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
        $thread = Thread::factory()->create();

        $reply = Reply::factory()->make();

        $this->post($thread->path() . '/replies', $reply->toArray())
                ->assertRedirect('/login');
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

    /** @test */
    public function a_reply_has_a_body()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->make(['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
                ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_user_cannot_delete_a_reply()
    {
        $this->withExceptionHandling();
    
        $reply = Reply::factory()->create();
    
        $this->delete("/replies/{$reply->id}")
                ->assertRedirect('login');
    
        $user = User::factory()->create();

        $this->actingAs($user)
                ->delete("/replies/{$reply->id}")
                ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_user_can_delete_a_reply()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reply = Reply::factory()->create(['owner_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
                ->assertStatus(302);
    
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
