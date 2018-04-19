<?php

namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider;

class ModelServiceProvider extends RouteBindingServiceProvider
{
    /**
     * Boot the authentication services for the application.
     */
    public function boot()
    {
        $this->binder->bind('job', 'App\Job');
    }
}