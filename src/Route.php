<?php

namespace Mitquinn\Hrs;

use Exception;
use Mitquinn\Hrs\Traits\RouteBuilder;
use Mitquinn\Hrs\Interfaces\RouteInterface;

/**
 * Class Route
 * @package Mitquinn\Hrs
 */
class Route implements RouteInterface
{
    /** RouteBuilder */
    use RouteBuilder;

    /** @var string $uri */
    protected string $uri;

    /** @var string $method */
    protected string $method;

    /** @var string $controller */
    protected string $controller;

    /** @var string $function */
    protected string $function;

    /**
     * I won't handle the OPTIONS, HEAD, PUT verbs. Its beyond the scope of this project.
     * @var string[] $acceptableVerb
     */
    public static array $acceptableVerb = ['GET', 'POST', 'PATCH', 'DELETE'];

    /**
     * Route constructor.
     * @param string $verb
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @throws Exception
     */
    public function __construct(string $verb, string $uri, string $controller, string $method)
    {
        $this->setMethod($verb);
        $this->setUri($uri);
        $this->setController($controller);
        $this->setFunction($controller, $method);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Route
     * @throws Exception
     */
    protected function setUri(string $uri): Route
    {
        if (empty($uri)) {
            throw new Exception('Route - setUri - Invalid uri.', 500);
        }
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Route
     * @throws Exception
     */
    protected function setMethod(string $method): Route
    {
        if (!in_array($method, Route::$acceptableVerb)) {
            throw new Exception('Route - setMethod - Invalid HTTP method.', 500);
        }
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     * @return Route
     * @throws Exception
     */
    protected function setController(string $controller): Route
    {
        if (!class_exists($controller)) {
            throw new Exception('Route - setController - Class does not exist.', 500);
        }

        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @param string $function
     * @return Route
     */
    protected function setFunction(string $controller, string $function): Route
    {
        if (!method_exists($controller, $function)) {
            throw new Exception('Route - setFunction - Function does not exist in that controller.', 500);
        }
        $this->function = $function;
        return $this;
    }
}