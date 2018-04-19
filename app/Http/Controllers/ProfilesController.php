<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    /**
     * Show the user's jobs
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function showJobs(User $user)
    {
        return $user->jobs;
    }
}