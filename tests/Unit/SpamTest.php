<?php

namespace Tests\Unit;

use App\Filters\Spam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpamTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_validates_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
    }
}
