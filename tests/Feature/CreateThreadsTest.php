<?php

namespace Tests\Feature;

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
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->withoutExceptionHandling();

        $thread = Thread::factory()->make();
        $this->post("/threads", $thread->toArray());
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_thread()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->make();
        $this->post("/threads", $thread->toArray());

        $this->get($thread->path())->assertSee($thread->title);
    }
}
