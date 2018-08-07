<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
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
    public function handle(Request $request, Closure $next)
    {
        if (!$this->userIsWorker(Auth::user())) {
            return response()->json(['error' => 'Only workers can access this endpoint'], 403);
        }

        return $next($request);
    }

    /**
     * Determine if use is a worker
     *
     * @param \App\User $user
     * @return bool
     */
    private function userIsWorker(User $user): bool
    {
        return $user->worker()->exists();
    }
}
