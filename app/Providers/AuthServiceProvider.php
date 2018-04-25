<?php

namespace App\Providers;

use App\ActiveUser;
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
                $user = $this->getActiveUser($request->input('token'));
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
        Gate::define('edit-job', function ($staff, $job) {
            return $staff->id == $job->staff_id;
        });

        Gate::define('create-application-response', function ($staff, $job) {
            return $staff->id == $job->staff_id;
        });

        Gate::define('view-education', function ($worker, $education) {
            return $worker->id == $education->worker_id;
        });

        Gate::define('view-experience', function ($worker, $experience) {
            return $worker->id == $experience->worker_id;
        });
    }

    /**
     * Returns ActiveUser by token
     *
     * @param string $token
     * @return \App\User
     */
    private function getActiveUser(string $token)
    {
        $activeUser = ActiveUser::where('token', $token)->firstOrFail();
        return $activeUser->user;
    }

}
