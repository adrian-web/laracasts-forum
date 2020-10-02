<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesPageTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function only_a_signed_in_user_can_view_his_profiles_page()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        $this->get('/profiles/' . $user->name)
            ->assertStatus(302); // Redirect to login page

        $userOther = User::factory()->create();
        $this->actingAs($userOther);

        $this->get('/profiles/' . $user->name)
            ->assertStatus(403); // Unauthorized
    }

    /** @test */
    public function a_user_has_a_profiles_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/profiles/' . $user->name)
                ->assertSee($user->name);
    }

    /** @test */
    public function profiles_page_shows_all_threads_associated_with_a_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}
