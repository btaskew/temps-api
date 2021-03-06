<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @param Job     $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Job $job)
    {
        $this->validate($request, [
            'cover_letter' => 'required|string',
            'education' => 'required|array',
            'experience' => 'required|array'
        ]);

        if (!$job->openForApplications()) {
            return $this->respondError('This job is no longer open for applications', 403);
        }

        $application = $job->apply(Auth::user()->worker, $request->input('cover_letter'));
        $application->saveExperience($request->input('experience'));

        return response()->json(['success' => 'Application submitted']);
    }
}
