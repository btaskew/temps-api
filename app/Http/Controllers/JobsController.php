<?php

namespace App\Http\Controllers;

use App\Job;

class JobsController extends Controller
{
    /**
     * Return all jobs
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Job::all();
    }

    /**
     * Return single job by ID
     *
     * @param string $id
     * @return Job
     */
    public function show(string $id)
    {
        return Job::findOrFail($id);
    }
}
