<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;

class ApprovedApplicationsController extends Controller
{
    public function store(Job $job, Application $application)
    {
        $this->authorize('approve-application', $job);

        $job->update(['approved_application_id' => $application->id]);
        return response()->json(['success' => 'Application approved']);
    }
}