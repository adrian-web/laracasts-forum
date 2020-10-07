<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_new_forum_thread()
    {
        $this->get("/threads/create")
                ->assertRedirect('/login');
        
        $this->post("/threads")
                ->assertRedirect('/login');
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = create('User', ['email_verified_at' => null]);
        $this->actingAs($user);

        $thread = make('Thread', ['user_id' => $user->id]);

        $this->post('/threads', $thread->toArray())
                ->assertRedirect('email/verify');

        $userVerified = create('User');
        $this->actingAs($userVerified);

        $threadVerified = make('Thread', ['user_id' => $userVerified->id]);

        $respone = $this->post('/threads', $threadVerified->toArray());

        $this->get($respone->headers->get('Location'))->assertSee($threadVerified->title);
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_thread()
    {
        $this->signIn();

        $thread = make('Thread');

        $respone = $this->post("/threads", $thread->toArray());

        $this->get($respone->headers->get('Location'))->assertSee($thread->title);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_forum_thread()
    {
        $thread = create('Thread');

        $this->delete($thread->path())
                ->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())
                ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_a_forum_thread()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth()->id()]);

        $reply = create('Reply', ['thread_id' => $thread->id]);

        $this->post('replies/' . $reply->id . '/favorites');
        
        $this->delete($thread->path())
                ->assertRedirect('/threads');

        $this->assertDatabaseMissing('threads', $thread->only('id'))
                ->assertDatabaseMissing('replies', $reply->only('id'));

        $this->assertEquals(0, Favorite::count());

        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_a_forum_thread()
    {
        $thread = create('Thread');

        $this->patch($thread->path())
                ->assertRedirect('/login');

        $this->signIn();

        $this->patch($thread->path())
                ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_update_a_forum_thread()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth()->id()]);

        $updatedTitle = 'Changed Title.';
        $updatedBody = 'Changed Body.';

        $this->patch($thread->path(), ['title' => $updatedTitle, 'body' => $updatedBody]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'title' => $updatedTitle, 'body' => $updatedBody]);
    }

    /** @test */
    public function users_may_only_create_a_thread_a_maximum_of_once_per_minute()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
    
        $thread = make('Thread');

        $this->post('/threads', $thread->toArray())
                ->assertStatus(302);
    
        $this->post('/threads', $thread->toArray())
                ->assertStatus(429);
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
        create('Channel', [], 2);

        $this->publishThread(['channel_id' => null])
                ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 99])
                ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
