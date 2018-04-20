<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WorkerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->userIsWorker(Auth::user())) {
            return response()->json(['error' => 'Only workers can access this endpoint'], 403);
        }

        return $next($request);
    }

    /**
     * @param \App\User $user
     * @return bool
     */
    private function userIsWorker($user)
    {
        return $user->worker()->exists();
    }
}
