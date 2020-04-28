<?php

namespace Mitquinn\Hrs;

use Exception;
use Mitquinn\Hrs\Helpers\RouterHelper;
use Mitquinn\Hrs\Traits\RouteBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mitquinn\Hrs\Abstracts\RouterAbstract;
use Mitquinn\Hrs\Interfaces\RouteInterface;
use Mitquinn\Hrs\Collections\RouteCollection;
use Mitquinn\Hrs\Interfaces\RouteCollectionInterface;


/**
 * Class Router
 * @package Mitquinn\Hrs
 */
class Router extends RouterAbstract
{
    /** @var RouteCollectionInterface $routeCollection */
    protected RouteCollectionInterface $routeCollection;

    /**
     * Router constructor.
     * @param RouteCollectionInterface|null $routeCollection
     */
    public function __construct(RouteCollectionInterface $routeCollection = null)
    {
        $this->setRouteCollection($routeCollection ?: new RouteCollection());
    }

    /**
     * @inheritDoc
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function dispatch(RequestInterface $request): ResponseInterface
    {
        /** @var ?Route $route */
        $route = $this->match($request, $this->getRouteCollection());

        if (is_null($route)) {
            throw new Exception('Router - dispatch - No matching route found.', 500);
        }

        return $this->handle($request, $route);
    }

    /**
     * @param RequestInterface $request
     * @param RouteInterface $route
     * @return ResponseInterface
     */
    protected function handle(RequestInterface $request, RouteInterface $route) : ResponseInterface
    {
        $className = $route->getController();
        $methodName = $route->getFunction();
        $params = [];

        if ($route->getMethod() == 'POST' || $route->getMethod() == 'PATCH') {
            $params[] = $request;
        }

        $params = array_merge($params, RouterHelper::extractWildCards($request->getUri()->getPath(), $route->getUri()));
        return call_user_func_array([$className, $methodName], $params);
    }


    /**
     * Matches the incoming request to a route within the RouteCollection.
     * @param RequestInterface $request
     * @param RouteCollectionInterface $routeCollection
     * @return RouteInterface|null
     */
    protected function match(RequestInterface $request, RouteCollectionInterface $routeCollection): ?RouteInterface
    {
        $routes = $routeCollection->getRoutes();

        foreach ($routes as $route) {
            if ($route->getMethod() != $request->getMethod()) {
                continue;
            }

            if (RouterHelper::matchPaths($request->getUri()->getPath(), $route->getUri())) {
                return $route;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     * @param RouteInterface $route
     * @return $this
     */
    public function registerRoute(RouteInterface $route): Router
    {
        $this->getRouteCollection()->addRoute($route);
        return $this;
    }

    /**
     * @inheritDoc
     * @param RouteInterface ...$routes
     * @return $this
     */
    public function registerRoutes(RouteInterface ...$routes): Router
    {
        foreach ($routes as $route) {
            $this->registerRoute($route);
        }
        return $this;
    }

    /**
     * @param string $path
     * @param string $controller
     * @return Router
     * @throws Exception
     */
    public function registerResource(string $path, string $controller): Router
    {
        $paths = RouterHelper::buildResourcePaths($path);
        $this->registerRoutes(
            RouteBuilder::index($paths['index'], $controller),
            RouteBuilder::get($paths['get'], $controller),
            RouteBuilder::create($paths['create'], $controller),
            RouteBuilder::update($paths['update'], $controller),
            RouteBuilder::delete($paths['delete'], $controller)
        );
        return $this;
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function listRoutes(): array
    {
        $routes = $this->getRouteCollection()->getRoutes();
        $response = [];
        foreach ($routes as $route) {
            $response[] = [
                'method' => $route->getMethod(),
                'uri' => $route->getUri(),
                'controller' => $route->getController(),
                'function' => $route->getFunction()
            ];
        }
        return $response;
    }

    /**
     * @inheritDoc
     * @return RouteCollectionInterface
     */
    public function getRouteCollection(): RouteCollectionInterface
    {
        $this->routeCollection ?: new RouteCollection();
        return $this->routeCollection;
    }

    /**
     * @inheritDoc
     * @param RouteCollection $routeCollection
     * @return Router
     */
    public function setRouteCollection(RouteCollection $routeCollection): Router
    {
        $this->routeCollection = $routeCollection;
        return $this;
    }
}