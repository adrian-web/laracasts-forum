<?php

namespace Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('Thread');

        $this->assertEquals($thread->path(), '/threads/' . $thread->channel->slug . '/' . $thread->id);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = create('Thread');

        $this->assertInstanceOf(User::class, $thread->creator);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $thread = create('Thread');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $thread = create('Thread');
        
        $thread->replies()->create([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $thread->replies);
    }

    /** @test */
    public function a_thread_has_a_channel()
    {
        $thread = create('Thread');
        
        $this->assertInstanceOf('App\Models\Channel', $thread->channel);
    }

    /** @test */
    public function it_can_be_subscribed_to()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->assertFalse($thread->isSubscribed);

        $thread->subscribe();

        $this->assertTrue($thread->fresh()->isSubscribed);
    }

    /** @test */
    public function it_knows_if_it_was_just_created()
    {
        $thread = create('Thread');
    
        $this->assertTrue($thread->wasJustCreated());
    
        $thread->created_at = Carbon::now()->subMonth();

        $this->assertFalse($thread->wasJustCreated());
    }
}
