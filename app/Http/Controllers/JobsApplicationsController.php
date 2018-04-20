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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Job $job)
    {
        return $job->applications;
    }

    /**
     * View a specific application
     *
     * @param Job         $job
     * @param Application $application
     * @return Application
     */
    public function show(Job $job, Application $application)
    {
        return $application;
    }
}