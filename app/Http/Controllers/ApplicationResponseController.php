<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;
use Illuminate\Http\Request;

class ApplicationResponseController extends Controller
{
    /**
     * Mark an application as approved
     *
     * @param Request     $request
     * @param Job         $job
     * @param Application $application
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Job $job, Application $application)
    {
        $this->authorize('create-application-response', $job);

        if ($application->response) {
            return $this->respondError('Application already responded to', 409);
        }

        $this->validate($request, [
            'type' => 'string|required|in:approved,rejected',
            'comment' => 'string|nullable|required',
            'reject_all' => 'bool|nullable|required'
        ]);

        $application->respond($request->only('type', 'comment', 'reject_all'));

        return response()->json(['success' => 'Application responded']);
    }
}