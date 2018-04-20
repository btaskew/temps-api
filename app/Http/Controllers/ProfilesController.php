<?php

namespace App\Http\Controllers;

use App\Staff;

class ProfilesController extends Controller
{
    /**
     * Show the user's jobs
     *
     * @param Staff $staff
     * @return \Illuminate\Http\JsonResponse
     */
    public function showJobs(Staff $staff)
    {
        return $this->respond($staff->jobs);
    }
}