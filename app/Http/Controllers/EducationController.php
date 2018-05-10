<?php

namespace App\Http\Controllers;

use App\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    /**
     * Return all users education
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respond(Auth::user()->worker->education);
    }

    /**
     * Return single education
     *
     * @param Education $education
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Education $education)
    {
        $this->authorize('access-education', $education);

        return $this->respond($education);
    }

    /**
     * Save the education
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'level' => 'required|string',
            'name' => 'required|string',
            'grade' => 'required|string',
            'institution' => 'required|string',
            'completion_date' => 'required|date'
        ]);
        
        Education::create([
            'level' => $request->input('level'),
            'name' => $request->input('name'),
            'grade' => $request->input('grade'),
            'institution' => $request->input('institution'),
            'completion_date' => $request->input('completion_date'),
            'worker_id' => Auth::user()->worker->id
        ]);

        return response()->json(['success' => 'Education saved']);
    }

    /**
     * Update the given education
     *
     * @param Request   $request
     * @param Education $education
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Education $education)
    {
        $this->authorize('access-education', $education);

        $this->validate($request, [
            'level' => 'string',
            'name' => 'string',
            'grade' => 'string',
            'institution' => 'string',
            'completion_date' => 'date'
        ]);

        $education->update(
            $request->only('level', 'name', 'grade', 'institution', 'completion_date')
        );

        return response()->json(['success' => 'Education updated']);
    }

    /**
     * Delete the given education
     *
     * @param Education $education
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Education $education)
    {
        $this->authorize('access-education', $education);

        $education->delete();

        return response()->json(['success' => 'Education deleted']);
    }
}
