<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function has_an_owner()
    {
        $reply = Reply::factory()->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
