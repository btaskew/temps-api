<?php

namespace App\Http\Controllers;

use App\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Return all users experience
     *
     * @return mixed
     */
    public function index()
    {
        return Auth::user()->worker->experience;
    }

    /**
     * Return single experience
     *
     * @param Experience $experience
     * @return Experience
     */
    public function show(Experience $experience)
    {
        $this->authorize('view-experience', $experience);

        return $experience;
    }

    /**
     * Save a new experience record
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|required',
            'type' => 'string|required|in:Paid work,Voluntary experience,Other',
            'start_date' => 'date|required',
            'end_date' => 'date|required',
        ]);

        return Experience::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'worker_id' => Auth::user()->worker->id
        ]);
    }
}