<?php

namespace Mitquinn\Hrs\Tests\Application;

use stdClass;
use Exception;
use Mitquinn\Hrs\Route;
use Mitquinn\Hrs\Router;
use PHPUnit\Framework\TestCase;
use Mitquinn\Hrs\Tests\Application\Controllers\PatientMetricController;
use Mitquinn\Hrs\Tests\Application\Controllers\PatientController;

/**
 * Class InitialTest
 * @package Mitquinn\Hrs\Test
 */
class ApplicationTest extends TestCase
{
    /** @var object $application */
    public object $application;

    /**
     * Builds up a silly application to use for testing.
     * @throws Exception
     */
    protected function setUp(): void
    {
        $application = new stdClass();
        $router = new Router();
        $router = $this->buildRoutes($router);
        $application->router = $router;
        $this->setApplication($application);
    }

    /**
     * @param Router $router
     * @return Router
     * @throws Exception
     */
    public function buildRoutes(Router $router): Router
    {
        $router->registerResource('patient', PatientController::class);
        $router->registerResource('patient.metric', PatientMetricController::class);
        return $router;
    }


    /**
     * Ensure the Router is initialized.
     */
    public function testApplicationInitialization()
    {
        $router = $this->getApplicationRouter();
        static::assertInstanceOf(Router::class, $router);
    }

    /**
     * @return object|stdClass
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param object|stdClass $application
     * @return ApplicationTest
     */
    public function setApplication(object $application): ApplicationTest
    {
        $this->application = $application;
        return $this;
    }

    /**
     * @return Router
     */
    public function getApplicationRouter(): Router
    {
        return $this->getApplication()->router;
    }

}