<?php

namespace Pest\Lumen\Testing\Console;

use App\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Application as Artisan;
use Pest\Lumen\Commands\ClosureCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Register a Closure based command with the application.
     *
     * @param  string  $signature
     * @param  \Closure  $callback
     * @return ClosureCommand
     */
    public function command($signature, \Closure $callback)
    {
        $command = new ClosureCommand($signature, $callback);
        Artisan::starting(function ($artisan) use ($command) {
            $artisan->add($command);
        });

        return $command;
    }
}
