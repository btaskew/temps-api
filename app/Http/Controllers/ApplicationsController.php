<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Support\Facades\Auth;

class ApplicationsController extends Controller
{
    /**
     * Create an application
     *
     * @param Job $job
     * @return \App\Application
     */
    public function store(Job $job)
    {
        return $job->apply(Auth::user());
    }
}