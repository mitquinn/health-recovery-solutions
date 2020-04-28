<?php


namespace Mitquinn\Hrs\Interfaces;


use Mitquinn\Hrs\Collections\RouteCollection;
use Tightenco\Collect\Support\Collection;

interface RouteCollectionInterface
{
    /**
     * @return RouteInterface[]|Collection
     */
    public function getRoutes(): Collection;

    /**
     * @param RouteInterface $route
     * @return RouteCollection
     */
    public function addRoute(RouteInterface $route): RouteCollectionInterface;
}