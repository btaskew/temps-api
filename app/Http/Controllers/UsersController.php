<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
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
