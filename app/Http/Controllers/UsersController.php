<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Store/signup a new user
     *
     * @param Request $request
     * @return \App\ActiveUser|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        if (User::where('email', $request->input('email'))->first()) {
            return $this->respondError(
                'User already exists with email ' . $request->input('email'),
                422
            );
        }

        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => '2',
        ])->setActive();
    }

    /**
     * Login an existing user
     *
     * @param Request $request
     * @return \App\ActiveUser|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();

        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->respondError('Invalid credentials', 401);
        }

        return $user->setActive();
    }

    /**
     * Logout an active user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = User::where('email', $request->input('email'))->firstOrFail();

        if (!$user->activeUser) {
            return response()->json(['success' => 'You are already logged out']);
        }

        $user->activeUser->delete();

        return response()->json(['success' => 'Log out successful']);
    }
}
