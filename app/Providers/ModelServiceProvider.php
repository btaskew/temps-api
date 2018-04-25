<?php

namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider;

class ModelServiceProvider extends RouteBindingServiceProvider
{
    /**
     * Binds models into the container for route model binding
     */
    public function boot()
    {
        $this->binder->bind('job', 'App\Job');
        $this->binder->bind('staff', 'App\Staff');
        $this->binder->bind('application', 'App\Application');
        $this->binder->bind('education', 'App\Education');
        $this->binder->bind('experience', 'App\Experience');
    }
}