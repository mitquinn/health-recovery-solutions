<?php

namespace Mitquinn\Hrs\Interfaces;

use Mitquinn\Hrs\Route;

/**
 * Interface RouteInterface
 * @package Mitquinn\Hrs\Interfaces
 */
interface RouteInterface
{

    public function getUri(): string;

    public function getMethod(): string;

    public function getController(): string;

    public function getFunction(): string;

}