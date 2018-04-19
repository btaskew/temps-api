<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Support\Facades\Auth;

class ApplicationsController extends Controller
{
    public function store(Job $job)
    {
        return $job->apply(Auth::user());
    }
}