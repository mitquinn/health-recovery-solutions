<?php


namespace Mitquinn\Hrs\Traits;

use Exception;
use Mitquinn\Hrs\Route;

/**
 * Trait RouteBuilder
 * @package Mitquinn\Hrs\Helpers
 */
trait RouteBuilder
{

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public static function index(string $uri, string $controller, string $method = 'index'): Route
    {
        return new Route('GET', $uri, $controller, $method);
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public static function get(string $uri, string $controller, string $method = 'get'): Route
    {
        return new Route('GET', $uri, $controller, $method);
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public static function create(string $uri, string $controller, string $method = 'create'): Route
    {
        return new Route('POST', $uri, $controller, $method);
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public static function update(string $uri, string $controller, string $method = 'update'): Route
    {
        return new Route('PATCH', $uri, $controller, $method);
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public static function delete(string $uri, string $controller, string $method = 'delete'): Route
    {
        return new Route('DELETE', $uri, $controller, $method);
    }

}