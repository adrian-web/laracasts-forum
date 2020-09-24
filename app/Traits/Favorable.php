<?php

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;

trait Favorable
{
    protected static function bootFavorable()
    {
        static::deleting(function ($model) {
            $model->favorites()->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }
}
