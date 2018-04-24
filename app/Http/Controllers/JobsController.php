<?php

namespace App\Http\Controllers;

use App\Filters\JobFilters;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    /**
     * Return all jobs
     *
     * @param JobFilters $filters
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(JobFilters $filters)
    {
        $jobs = Job::latest()->open()->withVacancies()->filter($filters);

        return $this->respond($jobs->get());
    }

    /**
     * Return single job by ID
     *
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Job $job)
    {
        return $this->respond($job);
    }

    /**
     * Create a new job
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|required',
            'tags' => 'array|required',
            'closing_date' => 'date|required',
            'open_vacancies' => 'numeric|required|min:1',
            'duration' => 'numeric|required|min:0.5',
            'rate' => 'numeric|required'
        ]);

        $job = Job::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'closing_date' => $request->input('closing_date'),
            'open_vacancies' => $request->input('open_vacancies'),
            'duration' => $request->input('duration'),
            'rate' => $request->input('rate'),
            'staff_id' => Auth::id()
        ]);

        $job->saveTags($request->input('tags'));

        return $this->respond($job);
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
