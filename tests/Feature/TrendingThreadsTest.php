<?php

namespace Tests\Feature;

use App\Models\Trending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->trending = new Trending;

        $this->trending->reset();
    }

    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_visited()
    {
        $this->assertCount(0, $this->trending->get());

        $thread = create('Thread');

        $this->get($thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, $trending[0]->title);
    }

    /** @test */
    public function it_can_remove_trending_thread_on_thread_deletion()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth()->id()]);
        
        $this->get($thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, $trending[0]->title);

        $thread->delete();

        $trendingEmpty = $this->trending->get();

        $this->assertCount(0, $trendingEmpty);
    }
}
