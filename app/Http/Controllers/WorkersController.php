<?php

namespace App\Http\Controllers;

use App\Worker;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
    /**
     * Show a workers information
     *
     * @param Worker $worker
     * @return Worker
     */
    public function show(Worker $worker)
    {
        $this->authorize('access-worker', $worker);

        return $worker;
    }

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

        return $this->respond($user->login());
    }

    /**
     * Edit a workers information
     *
     * @param Request $request
     * @param Worker  $worker
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Worker $worker)
    {
        $this->authorize('access-worker', $worker);

        $this->validate($request, [
            'address' => 'string',
            'website' => 'string'
        ]);

        $worker->update($request->only('address', 'website'));

        return response()->json(['success' => 'Profile updated successfully']);
    }
}
