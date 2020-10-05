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
