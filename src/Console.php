<?php

declare(strict_types=1);

namespace Pest\Lumen;

use Pest\Lumen\Testing\TestCase;
use Illuminate\Testing\PendingCommand;

/**
 * Call artisan command and return code.
 *
 * @return PendingCommand|int
 */
function artisan(string $command, array $parameters = [])
{
    return test()->artisan(...func_get_args());
}

/**
 * Disable mocking the console output.
 *
 * @return TestCase
 */
function withoutMockingConsoleOutput()
{
    return test()->withoutMockingConsoleOutput(...func_get_args());
}
