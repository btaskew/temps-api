<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
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
        if (!$this->userIsStaff(Auth::user())) {
            return response()->json(['error' => 'Only staff can access this endpoint'], 403);
        }

        return $next($request);
    }

    /**
     * @param \App\User $user
     * @return bool
     */
    private function userIsStaff($user)
    {
        return $user->staff()->exists();
    }
}
