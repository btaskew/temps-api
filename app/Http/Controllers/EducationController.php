<?php

namespace App\Http\Controllers;

use App\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
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
        
        return Education::create([
            'level' => $request->input('level'),
            'name' => $request->input('name'),
            'grade' => $request->input('grade'),
            'institution' => $request->input('institution'),
            'completion_date' => $request->input('completion_date'),
            'worker_id' => Auth::user()->worker->id
        ]);
    }
}