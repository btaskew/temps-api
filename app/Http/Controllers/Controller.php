<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Controller extends BaseController
{
    /**
     * Return an error response to the user
     *
     * @param string $message
     * @param int    $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError(string $message, int $code = 500)
    {
        return response()->json(['error' => $message], $code);
    }

    /**
     * Creates a new User
     *
     * @param Request $request
     * @return User
     */
    protected function createUser(Request $request)
    {
        $this->validateUserSignup($request);

        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    /**
     * Validate input for signup and determine if user already exists
     *
     * @param Request $request
     * @throws ConflictHttpException
     */
    protected function validateUserSignup(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        if (User::where('email', $request->input('email'))->first()) {
            throw new ConflictHttpException('User already exists with email ' . $request->input('email'));
        }
    }
}
