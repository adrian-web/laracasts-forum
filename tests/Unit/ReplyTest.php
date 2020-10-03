<?php

namespace Tests\Unit;

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
        $reply = create('Reply');

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    public function a_reply_has_favorites()
    {
        $reply = create('Reply');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $reply->favorites);
    }

    /** @test */
    public function a_reply_can_be_favorited()
    {
        $this->signIn();

        $reply = create('Reply');
        
        $reply->favorite();

        $this->assertCount(1, $reply->favorites);
    }
}
