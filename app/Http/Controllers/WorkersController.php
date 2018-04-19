<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkersController extends Controller
{
    /**
     * Signup a new worker user
     *
     * @param Request $request
     * @return \App\ActiveUser|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!$this->validateUserSignup($request)) {
            return $this->respondError(
                'User already exists with email ' . $request->input('email'),
                422
            );
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $user->worker()->create();

        return $user->setActive();
    }
}