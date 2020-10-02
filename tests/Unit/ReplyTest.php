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

    /** @test */
    public function a_reply_has_favorites()
    {
        $reply = Reply::factory()->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $reply->favorites);
    }

    /** @test */
    public function a_reply_can_be_favorited()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reply = Reply::factory()->create();
        
        $reply->favorite();

        $this->assertCount(1, $reply->favorites);
    }
}
