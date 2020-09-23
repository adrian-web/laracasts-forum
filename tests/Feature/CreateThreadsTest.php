<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_new_forum_thread()
    {
        $this->get("/threads/create")->assertRedirect('/login');
        
        $this->post("/threads")->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_thread()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->make();
        $respone = $this->post("/threads", $thread->toArray());

        $this->get($respone->headers->get('Location'))->assertSee($thread->title);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_forum_thread()
    {
        $this->withExceptionHandling();
        
        $thread = Thread::factory()->create();

        $this->delete($thread->path())
                ->assertRedirect('/login');

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->delete($thread->path())
                ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_delete_a_forum_thread()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create(['creator_id' => $user->id]);

        $reply = Reply::factory()->create(['thread_id' => $thread->id]);
        
        $this->delete($thread->path())
                ->assertRedirect('/threads');

        $this->assertDatabaseMissing('threads', $thread->only('id'))
                ->assertDatabaseMissing('replies', $reply->only('id'));
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
                ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
                ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        Channel::factory()->count(2)->create();

        $this->publishThread(['channel_id' => null])
                ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 99])
                ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->make($overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
