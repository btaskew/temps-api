<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Signup a new staff user
     *
     * @param Request $request
     * @return \App\ActiveUser|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $this->createUser($request);

        $user->staff()->create();

        return $user->setActive();
    }
}