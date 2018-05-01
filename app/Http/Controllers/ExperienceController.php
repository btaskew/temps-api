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
        $this->authorize('access-experience', $experience);

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
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string|in:Paid work,Voluntary experience,Other',
            'start_date' => 'required|date',
            'end_date' => 'date',
        ]);

        Experience::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'worker_id' => Auth::user()->worker->id
        ]);

        return response()->json(['success' => 'Experience saved']);
    }

    /**
     * Update the given experience
     *
     * @param Request   $request
     * @param Experience $experience
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Experience $experience)
    {
        $this->authorize('access-experience', $experience);

        $this->validate($request, [
            'title' => 'string',
            'description' => 'string',
            'type' => 'string|in:Paid work,Voluntary experience,Other',
            'start_date' => 'date',
            'end_date' => 'date',
        ]);

        $experience->update(
            $request->only('title', 'description', 'type', 'start_date', 'end_date')
        );

        return response()->json(['success' => 'Experience updated']);
    }

    /**
     * Delete the given experience
     *
     * @param Experience $experience
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Experience $experience)
    {
        $this->authorize('access-experience', $experience);

        $experience->delete();

        return response()->json(['success' => 'Experience deleted']);
    }
}
