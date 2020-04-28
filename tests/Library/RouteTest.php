<?php

namespace Mitquinn\Hrs\Tests\Library;

use Exception;
use Mitquinn\Hrs\Route;
use Mitquinn\Hrs\Tests\Application\ApplicationTest;
use Mitquinn\Hrs\Tests\Application\Controllers\PatientController;

/**
 * Class RouteTest
 * @package Mitquinn\Hrs\Tests\Library
 */
class RouteTest extends ApplicationTest
{

    /**
     * Testing Initializing with a Controller that doesnt exist.
     */
    public function testInitializeControllerDoesntExist()
    {
        static::expectException(Exception::class);
        static::expectExceptionMessage('Route - setController - Class does not exist.');
        static::expectExceptionCode(500);
        new Route('GET', 'https://127.0.0.1/tesing', 'DoesntExistController', 'index');
    }

    /**
     * Testing Initializing with a valid controller but no matching function.
     */
    public function testInitializeControllerDoesntHaveFunction()
    {
        static::expectException(Exception::class);
        static::expectExceptionMessage('Route - setFunction - Function does not exist in that controller.');
        static::expectExceptionCode(500);
        new Route('GET', 'https://127.0.0.1/tesing', PatientController::class, 'invalid');
    }

    /**
     * Testing Initializing with empty uri.
     */
    public function testInitializeEmptyUri()
    {
        static::expectException(Exception::class);
        static::expectExceptionMessage('Route - setUri - Invalid uri.');
        static::expectExceptionCode(500);
        new Route('GET', '', PatientController::class, 'index');
    }

    /**
     * Testing Initializing with Invalid Http Method.
     */
    public function testInitializeBadHttpMethod()
    {
        static::expectException(Exception::class);
        static::expectExceptionMessage('Route - setMethod - Invalid HTTP method.');
        static::expectExceptionCode(500);
        new Route('OPTION', 'https://127.0.0.1/tesing', PatientController::class, 'index');
    }
}