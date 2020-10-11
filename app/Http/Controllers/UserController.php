<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('user.show', [
                'user' => $user,
                'activities' => Activity::feed($user)
            ]);
    }
}
