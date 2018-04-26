<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Validates provided token for authenticated routes
     *
     * @return \App\User
     * @throws UnauthorizedHttpException
     */
    public function boot()
    {
        $this->setPermissions();

        $this->app['auth']->viaRequest('api', function ($request) {
            if (!$request->has('token')) {
                throw new UnauthorizedHttpException('unauthorised', 'Valid token not provided');
            }

            try {
                $user = User::where('token', $request->input('token'))->firstOrFail();
            } catch (ModelNotFoundException $exception) {
                throw new UnauthorizedHttpException('unauthorised', 'User not signed in');
            }

            return $user;
        });
    }

    /**
     * Sets permissions on model actions
     */
    private function setPermissions()
    {
        Gate::define('edit-job', function ($user, $job) {
            return $user->id == $job->staff_id;
        });

        Gate::define('create-application-response', function ($user, $job) {
            return $user->id == $job->staff_id;
        });

        Gate::define('access-education', function ($user, $education) {
            return $user->id == $education->worker_id;
        });

        Gate::define('access-experience', function ($user, $experience) {
            return $user->id == $experience->worker_id;
        });

        Gate::define('access-worker', function ($user, $worker) {
            return $user->id == $worker->user_id;
        });
    }
}
