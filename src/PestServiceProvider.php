<?php

declare(strict_types=1);

namespace Pest\Lumen;

use Illuminate\Support\ServiceProvider;
use Pest\Lumen\Commands\PestDatasetCommand;
use Pest\Lumen\Commands\PestTestCommand;

final class PestServiceProvider extends ServiceProvider
{
    /**
     * Register Artisan Commands.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PestTestCommand::class,
                PestDatasetCommand::class,
            ]);
        }
    }
}
