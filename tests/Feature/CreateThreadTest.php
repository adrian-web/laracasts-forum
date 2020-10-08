<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateThread;
use App\Http\Livewire\ManageThread;
use App\Models\Activity;
use App\Models\Favorite;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test  */
    public function guests_and_not_verified_users_cannot_see_thread_creation_modal_containing_livewire_component_on_main_page()
    {
        $this->get('threads')->assertDontSeeLivewire('create-thread');

        $user = create('User', ['email_verified_at' => null]);
        $this->actingAs($user);

        $this->get('threads')->assertDontSeeLivewire('create-thread');
    }

    /** @test  */
    public function verified_user_sees_thread_creation_modal_containing_livewire_component_on_main_page()
    {
        $this->signIn();

        $this->get('threads')->assertSeeLivewire('create-thread');
    }

    /** @test */
    public function a_guest_cannot_create_new_forum_thread()
    {
        Livewire::test(CreateThread::class)
            ->call('create')
            ->assertRedirect('login');

        // $this->get("/threads/create")
        //         ->assertRedirect('login');
        
        // $this->post("/threads")
        //         ->assertRedirect('login');
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = create('User', ['email_verified_at' => null]);
        $this->actingAs($user);

        Livewire::test(CreateThread::class)
            ->call('create')
            ->assertRedirect('email/verify');

        // $thread = make('Thread', ['user_id' => $user->id]);

        // $this->post('/threads', $thread->toArray())
        //         ->assertRedirect('email/verify');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_thread()
    {
        $this->signIn();

        $channel = create('Channel');

        Livewire::test(CreateThread::class)
            ->set('title', 'foo')
            ->set('body', 'bar')
            ->set('channel_id', $channel->id)
            ->call('create')
            ->assertRedirect("threads/{$channel->slug}/1");

        $this->assertTrue(Thread::whereTitle('foo')->exists());

        // $thread = make('Thread');

        // $respone = $this->post("threads", $thread->toArray());

        // $this->get($respone->headers->get('Location'))->assertSee($thread->title);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_forum_thread()
    {
        $thread = create('Thread');

        Livewire::test(ManageThread::class, ['thread' => $thread])
            ->call('delete')
            ->assertRedirect('login');

        $this->signIn();

        Livewire::test(ManageThread::class, ['thread' => $thread])
            ->call('delete')
            ->assertForbidden();

        // $this->delete($thread->path())
        //         ->assertRedirect('login');

        // $this->signIn();

        // $this->delete($thread->path())
        //         ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_a_forum_thread()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth()->id()]);

        $reply = create('Reply', ['thread_id' => $thread->id]);

        $reply->favorite();

        Livewire::test(ManageThread::class, ['thread' => $thread])
            ->call('delete');

        // $this->post('replies/' . $reply->id . '/favorites');
        
        // $this->delete($thread->path())
        //         ->assertRedirect('/threads');

        $this->assertDatabaseMissing('threads', $thread->only('id'))
                ->assertDatabaseMissing('replies', $reply->only('id'));

        $this->assertEquals(0, Favorite::count());

        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_a_forum_thread()
    {
        $thread = create('Thread');

        Livewire::test(ManageThread::class, ['thread' => $thread])
            ->call('update')
            ->assertRedirect('login');

        $this->signIn();

        Livewire::test(ManageThread::class, ['thread' => $thread])
            ->call('update')
            ->assertForbidden();

        // $this->patch($thread->path())
        //         ->assertRedirect('/login');

        // $this->patch($thread->path())
        //         ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_update_a_forum_thread()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth()->id()]);

        $updatedTitle = 'Changed Title.';
        $updatedBody = 'Changed Body.';

        Livewire::test(ManageThread::class, ['thread' => $thread])
            ->set('title', $updatedTitle)
            ->set('body', $updatedBody)
            ->call('update');

        // $this->patch($thread->path(), ['title' => $updatedTitle, 'body' => $updatedBody]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'title' => $updatedTitle, 'body' => $updatedBody]);
    }

    /** @test */
    public function users_may_only_create_a_thread_a_maximum_of_once_per_minute()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
    
        $channel = create('Channel');

        Livewire::test(CreateThread::class)
            ->set('title', 'foo')
            ->set('body', 'bar')
            ->set('channel_id', $channel->id)
            ->call('create')
            ->assertRedirect("threads/{$channel->slug}/1");

        $this->assertTrue(Thread::whereTitle('foo')->exists());

        Livewire::test(CreateThread::class)
            ->set('title', 'foofoo')
            ->set('body', 'barbar')
            ->set('channel_id', $channel->id)
            ->call('create');

        $this->assertFalse(Thread::whereTitle('foofoo')->exists());
        

        // $thread = make('Thread');

        // $this->post('/threads', $thread->toArray())
        //         ->assertStatus(302);
    
        // $this->post('/threads', $thread->toArray())
        //         ->assertStatus(429);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->signIn();
    
        $channel = create('Channel');

        Livewire::test(CreateThread::class)
            ->set('title', '')
            ->set('body', 'bar')
            ->set('channel_id', $channel->id)
            ->call('create')
            ->assertHasErrors('title');

        // $this->publishThread(['title' => null])
        //         ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->signIn();
    
        $channel = create('Channel');

        Livewire::test(CreateThread::class)
            ->set('title', 'foo')
            ->set('body', '')
            ->set('channel_id', $channel->id)
            ->call('create')
            ->assertHasErrors('body');

        // $this->publishThread(['body' => null])
        //         ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        create('Channel', [], 2);

        $this->signIn();
    
        Livewire::test(CreateThread::class)
            ->set('title', '')
            ->set('body', 'bar')
            ->set('channel_id', null)
            ->call('create')
            ->assertHasErrors('channel_id');

        Livewire::test(CreateThread::class)
            ->set('title', '')
            ->set('body', 'bar')
            ->set('channel_id', 99)
            ->call('create')
            ->assertHasErrors('channel_id');

        // $this->publishThread(['channel_id' => null])
        //         ->assertSessionHasErrors('channel_id');

        // $this->publishThread(['channel_id' => 99])
        //         ->assertSessionHasErrors('channel_id');
    }

    // public function publishThread($overrides = [])
    // {
    //     $this->signIn();

    //     $thread = make('Thread', $overrides);

    //     return $this->post('/threads', $thread->toArray());
    // }
}
