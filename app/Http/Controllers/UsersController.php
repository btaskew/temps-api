<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => app('hash')->make($request->input('password')),
        ]);
    }
}
