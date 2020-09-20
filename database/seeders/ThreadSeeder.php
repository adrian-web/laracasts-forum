<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()
                ->count(10)
                ->create();

        $channels = Channel::factory()
                    ->count(10)
                    ->create();

        foreach ($users as $user) {
            Thread::factory()
                        ->times(rand(1, 9))
                        ->create(['owner_id' => $user->id, 'channel_id' => last($channels->toArray())['id']]);
            Arr::pull($channels, count($channels->toArray()) - 1);
        }
    }
}
