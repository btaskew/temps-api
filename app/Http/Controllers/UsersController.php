<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Login an existing user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        try {
            $user = User::where('email', $request->input('email'))->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return $this->respondError('Invalid email', 401);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->respondError('Invalid password', 401);
        }

        return $this->respond($user->login());
    }

    /**
     * Logout an active user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();

        if (!$user->token) {
            return response()->json(['success' => 'You are already logged out']);
        }

        $user->update(['token' => null]);

        return response()->json(['success' => 'Log out successful']);
    }
}
