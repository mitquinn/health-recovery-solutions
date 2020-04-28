<?php

namespace Mitquinn\Hrs\Collections;

use Mitquinn\Hrs\Interfaces\RouteCollectionInterface;
use Tightenco\Collect\Support\Collection;
use Mitquinn\Hrs\Interfaces\RouteInterface;

/**
 * Class RouteCollection
 * @package Mitquinn\Hrs
 */
class RouteCollection implements RouteCollectionInterface
{
    /** @var Collection|RouteInterface[] $routes */
    protected Collection $routes;

    public function __construct()
    {
        $this->setRoutes(new Collection());
    }

    /**
     * @return RouteInterface[]|Collection
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    /**
     * @inheritDoc
     * @param RouteInterface $route
     * @return RouteCollection
     */
    public function addRoute(RouteInterface $route): RouteCollection
    {
        $this->getRoutes()->add($route);
        return $this;
    }


    /**
     * @param RouteInterface[]|Collection $routes
     * @return RouteCollection
     */
    protected function setRoutes($routes): RouteCollection
    {
        $this->routes = $routes;
        return $this;
    }

}