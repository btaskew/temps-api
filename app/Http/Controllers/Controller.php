<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

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
     * @param Request $request
     * @return bool
     */
    protected function validateUserSignup(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        if (User::where('email', $request->input('email'))->first()) {
            return false;
        }

        return true;
    }
}
