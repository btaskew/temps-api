<?php

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use DatabaseMigrations;

    /**
     * Default exception handler
     *
     * @var ExceptionHandler
     */
    private $oldExceptionHandler;

    public function setUp()
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Disable exception handling by default for better test debugging
     */
    private function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }
            public function report(\Exception $e)
            {
            }
            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }

    /**
     * Re-enable exception handling for testing exceptions
     *
     * @return $this
     */
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}
