<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_thread_creation_records_an_activity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $thread = Thread::factory()->create();
        
        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->id(),
            'type' => 'created_thread',
            'subject_id' => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function a_reply_creation_records_an_activity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reply = Reply::factory()->create();

        $this->assertEquals(2, Activity::count());

        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->id(),
            'type' => 'created_reply',
            'subject_id' => $reply->id,
            'subject_type' => 'App\Models\Reply'
        ]);
    }

    /** @test */
    public function it_fetches_an_activity_feed_for_a_given_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Thread::factory()->times(2)->create(['user_id' => auth()->id()]);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
