<?php

namespace App\Providers;

use App\ActiveUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the authentication services for the application.
     *
     * @return \App\User
     * @throws UnauthorizedHttpException
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            try {
                $user = $this->getActiveUser($request->input('token'));
            } catch (ModelNotFoundException $exception) {
                throw new UnauthorizedHttpException('unauthorised', 'Valid token not provided');
            }

            return $user;
        });
    }

    /**
     * @param string $token
     * @return \App\User
     */
    private function getActiveUser(string $token)
    {
        $activeUser = ActiveUser::where('token', $token)->firstOrFail();
        return $activeUser->user;
    }
}
