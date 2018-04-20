<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;

class ApprovedApplicationsController extends Controller
{
    /**
     * Mark an application as approved
     *
     * @param Job         $job
     * @param Application $application
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Job $job, Application $application)
    {
        $this->authorize('approve-application', $job);

        $job->update(['approved_application_id' => $application->id]);
        return response()->json(['success' => 'Application approved']);
    }
}