<?php

namespace Mitquinn\Hrs\Tests\Library;

use Exception;
use GuzzleHttp\Psr7\Request;
use Mitquinn\Hrs\Router;
use Mitquinn\Hrs\Tests\Application\ApplicationTest;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Router
 * @package Mitquinn\Hrs\Tests\Library
 */
class RouterTest extends ApplicationTest
{
    public function testListRoutes()
    {
        /** @var Router $router */
        $router = $this->application->router;
        $routesArray = $router->listRoutes();
        static::assertIsArray($routesArray);
        static::assertArrayHasKey('method', $routesArray[0]);
        static::assertArrayHasKey('uri', $routesArray[0]);
        static::assertArrayHasKey('controller', $routesArray[0]);
        static::assertArrayHasKey('function', $routesArray[0]);
    }


    public function handleDataProvider()
    {
        return [
            ['GET', 'https://127.0.0.1/patient', '200', 'PatientController', 'index'],
            ['GET', 'https://127.0.0.1/patient/1', '200', 'PatientController', 'get'],
            ['POST', 'https://127.0.0.1/patient', '201', 'PatientController', 'create'],
            ['PATCH', 'https://127.0.0.1/patient/1', '200', 'PatientController', 'update'],
            ['DELETE', 'https://127.0.0.1/patient/1', '200', 'PatientController', 'delete'],
            ['GET', 'https://127.0.0.1/patient/1/metric', '200', 'PatientMetricController', 'index'],
            ['GET', 'https://127.0.0.1/patient/1/metric/2', '200', 'PatientMetricController', 'get'],
            ['POST', 'https://127.0.0.1/patient/1/metric', '201', 'PatientMetricController', 'create'],
            ['PATCH', 'https://127.0.0.1/patient/1/metric/2', '200', 'PatientMetricController', 'update'],
            ['DELETE', 'https://127.0.0.1/patient/1/metric/2', '200', 'PatientMetricController', 'delete'],
        ];
    }


    /**
     * @dataProvider handleDataProvider
     * @param $method
     * @param $uri
     * @param $statusCode
     * @param $controller
     * @param $function
     * @throws Exception
     */
    public function testHandle($method, $uri, $statusCode, $controller, $function)
    {
        $request = new Request($method, $uri);
        $response = $this->getApplicationRouter()->dispatch($request);
        static::assertInstanceOf(ResponseInterface::class, $response);
        static::assertEquals($statusCode, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents(), true);
        static::assertEquals($controller, $body['controller']);
        static::assertEquals($function, $body['function']);
    }

    /**
     * @throws Exception
     */
    public function testRequestWithNoRouteRegistered()
    {
        static::expectException(Exception::class);
        static::expectExceptionMessage('Router - dispatch - No matching route found.');
        static::expectExceptionCode(500);
        $request = new Request('GET', 'https://127.0.0.1/doesntexist');
        $response = $this->getApplicationRouter()->dispatch($request);
    }

}