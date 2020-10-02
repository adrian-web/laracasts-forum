<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user)
    {
        if (Gate::forUser($user)->authorize('activity-feed')) {
            return view('profiles.show', [
                'profileUser' => $user,
                'activities' => Activity::feed($user)
            ]);
        }
    }
}
