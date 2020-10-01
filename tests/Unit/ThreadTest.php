<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = Thread::factory()->create();

        $this->assertEquals($thread->path(), '/threads/' . $thread->channel->slug . '/' . $thread->id);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf(User::class, $thread->creator);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $thread = Thread::factory()->create();
        
        $thread->replies()->create([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $thread->replies);
    }

    /** @test */
    public function a_thread_has_a_channel()
    {
        $thread = Thread::factory()->create();
        
        $this->assertInstanceOf('App\Models\Channel', $thread->channel);
    }
}
