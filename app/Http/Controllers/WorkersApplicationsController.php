<?php

namespace App\Http\Controllers;

use App\Application;
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
}