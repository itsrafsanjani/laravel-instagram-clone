<?php

namespace App\Http\Controllers;

use App\User;

class FollowController extends Controller
{
    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user);
    }
}
