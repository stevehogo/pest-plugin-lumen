<?php

namespace Pest\Lumen\Testing\Concerns;

use Illuminate\Console\OutputStyle;
use Illuminate\Testing\PendingCommand;
use Illuminate\Contracts\Console\Kernel;


trait InteractsWithConsole
{
    /**
     * Indicates if the console output should be mocked.
     *
     * @var bool
     */
    public $mockConsoleOutput = true;

    /**
     * All of the expected output lines.
     *
     * @var array
     */
    public $expectedOutput = [];

    /**
     * All of the expected text to be present in the output.
     *
     * @var array
     */
    public $expectedOutputSubstrings = [];

    /**
     * All of the output lines that aren't expected to be displayed.
     *
     * @var array
     */
    public $unexpectedOutput = [];

    /**
     * All of the text that is not expected to be present in the output.
     *
     * @var array
     */
    public $unexpectedOutputSubstrings = [];

    /**
     * All of the expected output tables.
     *
     * @var array
     */
    public $expectedTables = [];

    /**
     * All of the expected questions.
     *
     * @var array
     */
    public $expectedQuestions = [];

    /**
     * All of the expected choice questions.
     *
     * @var array
     */
    public $expectedChoices = [];
    /**
     * Call artisan command and return code.
     *
     * @param  null|string  $command
     * @param  array  $parameters
     * @return \Illuminate\Testing\PendingCommand|int
     */
    public function artisan(?string $command = null, $parameters = [])
    {
        if (! $this->mockConsoleOutput) {
            return $this->app[Kernel::class]->call($command, $parameters);
        }
        return new PendingCommand($this, $this->app, $command, $parameters);
    }
    /**
     * Disable mocking the console output.
     *
     * @return $this
     */
    public function withoutMockingConsoleOutput()
    {
        $this->mockConsoleOutput = false;

        $this->app->offsetUnset(OutputStyle::class);

        return $this;
    }


    /**
     * Get the latest artisan console output
     *
     * @return string
     */
    public function artisanOutput(): string
    {
        return $this->app[Kernel::class]->output();
    }

    /**
     * Get the Artisan Kernel instance
     *
     * @return Kernel
     */
    public function console(): Kernel
    {
        return $this->app[Kernel::class];
    }
}
