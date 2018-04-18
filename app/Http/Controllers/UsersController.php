<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UsersController extends Controller
{
    /**
     * Store/signup a new user
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        if (User::where('email', $request->input('email'))->first()) {
            return response()
                ->json(
                    ['error' => 'User already exists with email ' . $request->input('email')],
                    422
                );
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->setActive();

        return $user->activeUser;
    }

    /**
     * Login an existing user
     *
     * @param Request $request
     * @return ActiveUser
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();

        if (!Hash::check($request->input('password'), $user->password)) {
            throw new UnauthorizedHttpException('Basic', 'Invalid credentials');
        }

        $user->setActive();

        return $user->activeUser;
    }
}
