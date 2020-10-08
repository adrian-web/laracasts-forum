<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateReply;
use App\Http\Livewire\ManageReply;
use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test  */
    public function guest_cannot_see_reply_creation_containing_livewire_component_on_thread_page()
    {
        $thread = create('Thread');

        $this->get($thread->path())->assertDontSeeLivewire('create-reply');
    }

    /** @test  */
    public function authenticated_user_sees_reply_creation_containing_livewire_component_on_thread_page()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->get($thread->path())->assertSeeLivewire('create-reply');
    }

    /** @test */
    public function unauthenticated_user_may_not_add_a_reply()
    {
        $thread = create('Thread');

        Livewire::test(CreateReply::class, ['thread' => $thread])
            ->call('create')
            ->assertRedirect('login');

        // $reply = make('Reply');

        // $this->post($thread->path() . '/replies', $reply->toArray())
        //         ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
    
        $thread = create('Thread');

        Livewire::test(CreateReply::class, ['thread' => $thread])
            ->set('body', 'foobar')
            ->call('create');

        $this->assertTrue(Reply::whereBody('foobar')->exists());

        // $reply = make('Reply');

        // $this->post($thread->path() . '/replies', $reply->toArray());

        // $this->get($thread->path())
        //         ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_has_a_body()
    {
        $this->signIn();

        $thread = create('Thread');

        Livewire::test(CreateReply::class, ['thread' => $thread])
            ->set('body', '')
            ->call('create')
            ->assertHasErrors('body');
        
        // $reply = make('Reply', ['body' => null]);

        // $this->post($thread->path() . '/replies', $reply->toArray())
        //         ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_user_cannot_delete_a_reply()
    {
        $reply = create('Reply');

        Livewire::test(ManageReply::class, ['reply' => $reply])
            ->call('delete')
            ->assertRedirect('login');

        // $this->delete("/replies/{$reply->id}")
        //         ->assertRedirect('login');
    
        $this->signIn();

        Livewire::test(ManageReply::class, ['reply' => $reply])
            ->call('delete')
            ->assertForbidden();

        // $this->signIn()
        //         ->delete("/replies/{$reply->id}")
        //         ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_user_can_delete_a_reply()
    {
        $this->signIn();

        $reply = create('Reply', ['user_id' => auth()->id()]);

        Livewire::test(ManageReply::class, ['reply' => $reply])
            ->call('delete');

        // $this->delete("/replies/{$reply->id}")
        //         ->assertStatus(302);
    
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $reply = create('Reply');
    
        Livewire::test(ManageReply::class, ['reply' => $reply])
            ->call('update')
            ->assertRedirect('login');

        // $this->patch("/replies/{$reply->id}")
        //         ->assertRedirect('login');
    
        $this->signIn();

        Livewire::test(ManageReply::class, ['reply' => $reply])
            ->call('update')
            ->assertForbidden();

        // $this->signIn()
        //         ->patch("/replies/{$reply->id}")
        //          ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
    
        $reply = create('Reply', ['user_id' => auth()->id()]);
    
        $updatedReply = 'Changed.';

        Livewire::test(ManageReply::class, ['reply' => $reply])
            ->set('body', $updatedReply)
            ->call('update');

        // $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
    
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_saved()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        
        $thread = create('Thread');

        Livewire::test(CreateReply::class, ['thread' => $thread])
            ->set('body', 'Yahoo Customer Support')
            ->call('create')
            ->assertHasErrors('body');
        
        // $reply = make('Reply', [
        //     'body' => 'Yahoo Customer Support'
        // ]);

        // $this->expectException(\Exception::class);

        // $this->post($thread->path() . '/replies', $reply->toArray());
    }

    /** @test */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
    
        $thread = create('Thread');
        
        Livewire::test(CreateReply::class, ['thread' => $thread])
            ->set('body', 'foo')
            ->call('create');

        $this->assertTrue(Reply::whereBody('foo')->exists());

        Livewire::test(CreateReply::class, ['thread' => $thread])
            ->set('body', 'bar')
            ->call('create');

        $this->assertFalse(Reply::whereBody('bar')->exists());

        // $reply = make('Reply');
    
        // $this->post($thread->path() . '/replies', $reply->toArray())
        //         ->assertStatus(302);
    
        // $this->post($thread->path() . '/replies', $reply->toArray())
        //         ->assertStatus(429);
    }
}
