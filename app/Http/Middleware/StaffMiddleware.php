<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
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
    public function handle(Request $request, Closure $next)
    {
        if (!$this->userIsStaff(Auth::user())) {
            return response()->json(['error' => 'Only staff can access this endpoint'], 403);
        }

        return $next($request);
    }

    /**
     * Determine if user is staff
     *
     * @param \App\User $user
     * @return bool
     */
    private function userIsStaff(User $user): bool
    {
        return $user->staff()->exists();
    }
}
