<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    /**
     * Return all jobs
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        if ($request->has('tags')) {
            return Job::query()
                ->join('tags', 'jobs.id', '=', 'tags.job_id')
                ->filterByTags($request->input('tags'))
                ->get();
        }

        return Job::all();
    }

    /**
     * Return single job by ID
     *
     * @param Job $job
     * @return Job
     */
    public function show(Job $job)
    {
        return $job;
    }

    /**
     * Create a new job
     *
     * @param Request $request
     * @return Job
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|required',
            'tags' => 'array|required'
        ]);

        $job = Job::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'staff_id' => Auth::id()
        ]);

        $job->saveTags($request->input('tags'));

        return $job;
    }

    /**
     * Delete the given job
     *
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete-job', $job);

        $job->delete();
        return response()->json(['success' => 'Job has been deleted']);
    }
}
