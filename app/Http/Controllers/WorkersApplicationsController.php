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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respond(Auth::user()->worker->applications);
    }

    /**
     * Return a specific application
     *
     * @param Application $application
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Application $application)
    {
        return $this->respond($application);
    }

    /**
     * Create an application
     *
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Job $job)
    {
        return $this->respond(
            $job->apply(Auth::user()->worker)
        );
    }
}