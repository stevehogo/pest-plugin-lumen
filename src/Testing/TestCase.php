<?php
declare(strict_types=1);

namespace Pest\Lumen\Testing;

use  Laravel\Lumen\Testing\TestCase as LumenTestCase;

abstract class TestCase extends LumenTestCase
{

    use Concerns\Testing;
    use Concerns\InteractsWithAuthentication;
    use Concerns\InteractsWithEvent;
    use Concerns\InteractsWithJob;
    use Concerns\InteractsWithConsole;
    use Concerns\InteractsWithSession;
    use Concerns\InteractsWithExceptionHandling;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->setUpTestEnvironment();

        $this->runThroughAnnotatedMethods();
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
