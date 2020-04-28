<?php

namespace Mitquinn\Hrs\Interfaces;

use Mitquinn\Hrs\Collections\RouteCollection;

/**
 * Interface RouterRegisterInterface
 * This interface handles the registration of routes with the Router class.
 * @package Mitquinn\Hrs\Interfaces
 */
interface RouterRegisterInterface
{
    /**
     * Register a single Route to the RouteCollection.
     * @param RouteInterface $route
     * @return RouterRegisterInterface
     */
    public function registerRoute(RouteInterface $route): RouterRegisterInterface;

    /**
     * Register multiple Route to the RouteCollection.
     * @param RouteInterface ...$routes
     * @return RouterRegisterInterface
     */
    public function registerRoutes(RouteInterface ...$routes): RouterRegisterInterface;

    /**
     * @param string $path
     * @param string $controller
     * @return RouterRegisterInterface
     */
    public function registerResource(string $path, string $controller): RouterRegisterInterface;


    /**
     * Returns an array with some basic information about the Routes registered in the RouteCollection.
     * @return array
     */
    public function listRoutes(): array;

    /**
     * Returns the classes RouteCollection. Will instantiate if does not exist.
     * @return RouteCollectionInterface
     */
    public function getRouteCollection(): RouteCollectionInterface;

    /**
     * Sets the RouteCollection on the class.
     * @param RouteCollection $routeCollection
     * @return RouterRegisterInterface
     */
    public function setRouteCollection(RouteCollection $routeCollection): RouterRegisterInterface;

}