<?php

namespace App\Http\Controllers;

use App\ApplicationResponse;
use App\Job;
use App\Worker;

class StatsController extends Controller
{
    /**
     * Return all application stats
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respond([
            'jobs_count' => Job::count(),
            'workers_count' => Worker::count(),
            'approved_count' => ApplicationResponse::where('type', '=', 'approved')->count()
        ]);
    }
}