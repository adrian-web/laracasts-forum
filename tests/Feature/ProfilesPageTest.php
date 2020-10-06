<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesPageTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function only_a_signed_in_user_can_view_his_profiles_page()
    {
        $user = create('User');

        $this->get('/profiles/' . $user->username)
            ->assertStatus(302); // Redirect to login page

        $userOther = create('User');
        $this->signIn($userOther);

        $this->get('/profiles/' . $user->username)
            ->assertStatus(403); // Unauthorized
    }

    /** @test */
    public function a_user_has_a_profiles_page()
    {
        $user = create('User');
        $this->signIn($user);

        $this->get('/profiles/' . $user->username)
                ->assertSee($user->name);
    }

    /** @test */
    public function profiles_page_shows_all_threads_associated_with_a_user()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->username)
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}
