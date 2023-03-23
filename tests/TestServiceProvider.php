<?php

namespace Tests;

use Illuminate\Support\ServiceProvider;
class TestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../resources/routes.php');
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return null;
            }
        });
        //
        $this->loadMigrationsFrom(__DIR__.'/../resources/database/migrations/');
    }
}
