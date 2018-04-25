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
     * @return mixed
     */
    public function index()
    {
        return Auth::user()->worker->education;
    }

    /**
     * Return single education
     *
     * @param Education $education
     * @return Education
     */
    public function show(Education $education)
    {
        $this->authorize('view-education', $education);

        return $education;
    }

    /**
     * Save the education
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'level' => 'string|required',
            'name' => 'string|required',
            'grade' => 'string|required',
            'institution' => 'string|required',
            'completion_date' => 'date|required'
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
}
