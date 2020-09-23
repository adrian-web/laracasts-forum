<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->get('/profiles/' . $user->name)
                ->assertSee($user->name);
    }

    /** @test */
    public function profiles_page_shows_all_threads_associated_with_a_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $thread = Thread::factory()->create(['creator_id' => $user->id]);

        $this->get('/profiles/' . $user->name)
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}