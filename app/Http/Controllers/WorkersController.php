<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkersController extends Controller
{
    /**
     * Signup a new worker user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $this->createUser($request);

        $user->worker()->create();

        return $this->respond($user->setActive());
    }
}
