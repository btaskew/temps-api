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

        return response()->json(['success' => 'Job created']);
    }

    /**
     * Update the given job
     *
     * @param Request $request
     * @param Job     $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Job $job)
    {
        $this->validate($request, [
            'title' => 'string',
            'description' => 'string',
            'tags' => 'array',
            'closing_date' => 'date',
            'open_vacancies' => 'numeric|min:1',
            'duration' => 'numeric|min:0.5',
            'rate' => 'numeric'
        ]);

        $this->authorize('edit-job', $job);

        $job->update(
            $request->only('title', 'description', 'closing_date', 'open_vacancies', 'duration', 'rate')
        );

        if ($request->has('tags')) {
            $job->saveTags($request->input('tags'));
        }

        return response()->json(['success' => 'Job updated']);
    }

    /**
     * Delete the given job
     *
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Job $job)
    {
        $this->authorize('edit-job', $job);

        $job->delete();

        return response()->json(['success' => 'Job has been deleted']);
    }
}
