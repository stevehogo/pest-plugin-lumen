<?php

namespace Tests;

use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Router;
use Pest\Lumen\PestServiceProvider;
use Pest\Lumen\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

    protected function withFacade(): bool
    {
        return true;
    }

    protected function withEloquent(): bool
    {
        return true;
    }

    protected function serviceProviders(): array
    {
        return [
            PestServiceProvider::class,
            TestServiceProvider::class
        ];
    }

    protected function routes(Router $router): void
    {
        //
    }

    protected function globalMiddlewares(Application $app): array
    {
        return [];
    }

    protected function routeMiddlewares(Application $app): array
    {
        return [];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        // register app created event
        $this->afterApplicationCreated(function ($app){
            $this->getEnvironmentSetUp($app);
        });
        parent::setUp();
        $old = $this->mockConsoleOutput;
        $this->mockConsoleOutput = !$old;
        $this->artisan('migrate', [
            '--force'=>true,
            '--database' => 'testbench'
        ]);
        $this->mockConsoleOutput = $old;
    }

    protected function getEnvironmentSetUp($app): void
    {

        $app->configure('auth');
        $app['config']->set('view.paths', [
            __DIR__.'/../resources/views',
        ]);
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
