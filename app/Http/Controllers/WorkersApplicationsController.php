<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;
use Illuminate\Support\Facades\Auth;

class WorkersApplicationsController extends Controller
{
    /**
     * Return all of the authenticated worker's applications
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Auth::user()->worker->applications;
    }

    /**
     * Return a specific application
     *
     * @param Application $application
     * @return Application
     */
    public function show(Application $application)
    {
        return $application;
    }

    /**
     * Create an application
     *
     * @param Job $job
     * @return \App\Application
     */
    public function store(Job $job)
    {
        return $job->apply(Auth::user()->worker);
    }
}