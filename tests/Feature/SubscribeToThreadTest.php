<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_guest_cannot_subscribe_to_anything()
    {
        $this->withoutExceptionHandling();
    
        $thread = Thread::factory()->create();

        $thread->subscribe();

        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_can_subscribe_to_a_thread()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();

        $thread->subscribe();

        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_may_only_subscribe_to_a_thread_once()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();

        $thread->subscribe();
        $thread->subscribe();
    
        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function a_guest_cannot_unsubscribe_anything()
    {
        $this->withoutExceptionHandling();

        $thread = Thread::factory()->create();

        $thread->subscriptions()->create(['user_id' => $thread->user_id]);

        $this->assertCount(1, $thread->subscriptions);

        $thread->unsubscribe();

        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_can_unsubscribe_to_a_thread()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();

        $thread->subscribe();

        $this->assertCount(1, $thread->subscriptions);

        $thread->unsubscribe();
    
        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
