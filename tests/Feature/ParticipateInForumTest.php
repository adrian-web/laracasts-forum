<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function unauthenticated_user_may_not_add_a_reply()
    {
        $thread = create('Thread');

        $reply = make('Reply');

        $this->post($thread->path() . '/replies', $reply->toArray())
                ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
    
        $thread = create('Thread');

        $reply = make('Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
                ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_has_a_body()
    {
        $this->signIn();

        $thread = create('Thread');
        
        $reply = make('Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
                ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_user_cannot_delete_a_reply()
    {
        $reply = create('Reply');

        $this->delete("/replies/{$reply->id}")
                ->assertRedirect('login');
    
        $user = create('User');

        $this->actingAs($user)
                ->delete("/replies/{$reply->id}")
                ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_user_can_delete_a_reply()
    {
        $this->signIn();

        $reply = create('Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
                ->assertStatus(302);
    
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $reply = create('Reply');
    
        $this->patch("/replies/{$reply->id}")
                ->assertRedirect('login');
    
        $this->signIn()
                ->patch("/replies/{$reply->id}")
                 ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
    
        $reply = create('Reply', ['user_id' => auth()->id()]);
    
        $updatedReply = 'Changed.';

        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
    
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
