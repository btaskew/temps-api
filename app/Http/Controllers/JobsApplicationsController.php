<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;

class JobsApplicationsController extends Controller
{
    /**
     * Return a given jobs application
     *
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Job $job)
    {
        return $this->respond($job->applications);
    }

    /**
     * View a specific application
     *
     * @param Application $application
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Application $application)
    {
        return $this->respond($application);
    }
}