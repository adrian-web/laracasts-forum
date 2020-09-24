<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    use Favorable;
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $withCount = ['favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
