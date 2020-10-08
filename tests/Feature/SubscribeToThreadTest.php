<?php

namespace Tests\Feature;

use App\Http\Livewire\ThreadSidebar;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test  */
    public function thread_subscribing_containing_livewire_component_on_thread_page()
    {
        $thread = create('Thread');

        $this->get($thread->path())->assertSeeLivewire('thread-sidebar');
    }

    /** @test */
    public function a_guest_cannot_subscribe_to_anything()
    {
        $thread = create('Thread');

        Livewire::test(ThreadSidebar::class, ['thread' => $thread])
            ->call('subscribe')
            ->assertRedirect('login');

        // $thread->subscribe();

        $this->assertCount(0, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_can_subscribe_to_a_thread()
    {
        $this->signIn();

        $thread = create('Thread');

        Livewire::test(ThreadSidebar::class, ['thread' => $thread])
            ->call('subscribe');

        // $thread->subscribe();

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    // /** @test */
    // public function an_authenticated_user_may_only_subscribe_to_a_thread_once()
    // {
    //     $this->signIn();

    //     $thread = create('Thread');

    //     $thread->subscribe();
    //     $thread->subscribe();
    
    //     $this->assertCount(1, $thread->subscriptions);
    // }

    /** @test */
    public function an_authenticated_user_can_unsubscribe_to_a_thread()
    {
        $this->signIn();

        $thread = create('Thread');

        Livewire::test(ThreadSidebar::class, ['thread' => $thread])
            ->call('subscribe');

        // $thread->subscribe();

        $this->assertCount(1, $thread->fresh()->subscriptions);

        Livewire::test(ThreadSidebar::class, ['thread' => $thread])
            ->call('subscribe');

        // $thread->unsubscribe();
    
        $this->assertCount(0, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function deleting_a_thread_removes_its_associated_subscriptions()
    {
        $this->signIn();

        $thread = create('Thread');

        $thread->subscribe();

        $this->assertCount(1, $thread->fresh()->subscriptions);

        $thread->delete();

        $this->assertDatabaseMissing('threads', $thread->only('id'));

        $this->assertEquals(0, Subscription::count());
    }
}
