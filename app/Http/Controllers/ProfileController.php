<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user)
    {
        return view('profiles.show', [
                'user' => $user,
                'activities' => Activity::feed($user)
            ]);
    }
}
