<?php

namespace App\Http\Controllers;

use App\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
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