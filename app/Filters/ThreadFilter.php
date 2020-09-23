<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilter extends Filter
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username.
     *
     * @param  string $username
     * @return Builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('owner_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return $this
     */
    protected function popular()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
