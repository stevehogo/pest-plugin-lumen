<?php
declare(strict_types=1);

namespace Pest\Lumen\Testing;
use Anik\Testbench\Concerns\Annotation;
use Anik\Testbench\Concerns\Auth;
use Anik\Testbench\Concerns\Database;
use Anik\Testbench\Concerns\Event;
use Anik\Testbench\Concerns\Job;
use Anik\Testbench\Concerns\Testing;
use Laravel\Lumen\Testing\Concerns\MakesHttpRequests;
use Pest\Lumen\Testing\Concerns\InteractsWithSession;
use PHPUnit\Framework\TestCase as PHPUnit;

abstract class TestCase extends PHPUnit
{
    use Annotation;
    use Auth;
    use Concerns\CreateApplication;
    use Database;
    use Event;
    use Job;
    use MakesHttpRequests;
    use Testing;
    use Concerns\InteractsWithAuthentication;
    use Concerns\InteractsWithConsole;
    use Concerns\InteractsWithSession;
    use Concerns\InteractsWithExceptionHandling;

    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->setUpTestEnvironment();

        $this->runThroughAnnotatedMethods();
        $this->afterApplicationCreated(function ($app){
            $uses = array_flip(class_uses_recursive(get_class($this)));
            if (isset($uses[InteractsWithSession::class])) {
                $this->initSession($app);
            }
        });
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $this->tearDownTestEnvironment();
    }
}
