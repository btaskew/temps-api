<?php

namespace App\Http\Controllers;

use App\Job;

class JobsController extends Controller
{
    public function index()
    {
        return Job::all();
    }

    public function show($id)
    {
        return Job::findOrFail($id);
    }
}
