<?php

namespace Pest\Lumen\Testing\Concerns;

use Pest\Lumen\Testing\Console\Kernel as ConsoleKernel;
use Laravel\Lumen\Exceptions\Handler;
use Composer\Autoload\ClassLoader;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Router;
use ReflectionClass;

trait CreateApplication
{
    protected function withFacade(): bool
    {
        return false;
    }

    protected function withEloquent(): bool
    {
        return false;
    }

    protected function serviceProviders(): array
    {
        return [];
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

    public function createApplication(): Application
    {
        $app = $this->resolveApplication();
        $this->loadWithFacade($app);
        $this->loadWithEloquent($app);
        $this->bindExceptionHandler($app);
        $this->bindConsoleKernel($app);
        $this->registerServiceProviders($app);
        $this->bindRouter($app);
        $this->registerMiddlewares($app);
        return $app;
    }

    final protected function registerMiddlewares(Application $app)
    {
        if ($routeMiddlewares = $this->routeMiddlewares($app)) {
            $app->routeMiddleware($routeMiddlewares);
        }

        if ($globalMiddlewares = $this->globalMiddlewares($app)) {
            $app->middleware($globalMiddlewares);
        }
    }

    final protected function lumenBasePath(): string
    {
        $reflection = new ReflectionClass(ClassLoader::class);

        return dirname(dirname($reflection->getFileName())) . '/laravel/lumen';
    }

    protected function resolveApplication(): Application
    {
        $path = env('APP_BASE_PATH') ?? $this->lumenBasePath();
        return $app = new Application($path);
    }

    final protected function loadWithFacade(Application $app): void
    {
        if (false === $this->withFacade()) {
            return;
        }

        $app->withFacades();
    }

    final protected function loadWithEloquent(Application $app): void
    {
        if (false === $this->withEloquent()) {
            return;
        }

        $app->withEloquent();
    }

    protected function dontReportExceptions(): array
    {
        return [];
    }

    final protected function bindExceptionHandler(Application $app): void
    {
        $app->singleton(ExceptionHandler::class, function () use ($app) {
            return new class ($this->dontReportExceptions()) extends Handler {
                public function __construct(array $dontReport = [])
                {
                    $this->dontReport = array_merge($this->dontReport, $dontReport);
                }
            };
        });
    }

    final protected function bindConsoleKernel(Application $app): void
    {
        $app->singleton(Kernel::class, function () use ($app) {
            return new ConsoleKernel($app);
        });
    }

    final protected function registerServiceProviders(Application $app): void
    {
        foreach ($this->serviceProviders() as $provider) {
            $app->register($provider);
        }
    }

    final protected function bindRouter(Application $app)
    {
        $app->router->get('/', function () use ($app) {
            return $app->version();
        });

        $this->routes($app->router);
    }
}
