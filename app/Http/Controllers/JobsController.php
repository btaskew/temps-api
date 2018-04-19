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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Job::all();
    }

    /**
     * Return single job by ID
     *
     * @param string $id
     * @return Job
     */
    public function show(string $id)
    {
        return Job::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|required'
        ]);

        return Job::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => Auth::id()
        ]);
    }
}
