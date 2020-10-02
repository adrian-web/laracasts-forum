<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotifyTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function reply_created_by_other_user_in_a_subscribed_thread_creates_a_notification()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();

        $thread->subscribe();

        $this->assertCount(0, $user->notifications);

        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $this->assertCount(1, $user->fresh()->notifications);
    }

    /** @test */
    public function reply_created_by_current_user_in_a_subscribed_thread_doesnt_create_a_notification()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();

        $thread->subscribe();

        $this->assertCount(0, $user->notifications);

        $reply = Reply::factory()->create(['user_id' => $user->id, 'thread_id' => $thread->id]);

        $this->assertCount(0, $user->fresh()->notifications);
    }
}
