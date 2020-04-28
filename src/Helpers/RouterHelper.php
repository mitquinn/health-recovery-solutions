<?php


namespace Mitquinn\Hrs\Helpers;

use Mitquinn\Hrs\Traits\RouteBuilder;

/**
 * Class RouterHelper
 * @package Mitquinn\Hrs
 */
class RouterHelper
{

    /**
     * @param string $path
     * @param string $routePath
     * @return array
     */
    public static function extractWildCards(string $path, string $routePath): array
    {
        $wildcards = [];
        $pathArray = RouterHelper::explodePath($path);
        $routeArray = RouterHelper::explodePath($routePath);
        foreach ($routeArray as $key => $part) {
            if (RouterHelper::isWildCard($part)) {
                $wildcards[] = $pathArray[$key];
            }
        }
        return $wildcards;
    }

    /**
     * @param string $path
     * @param string $routePath
     * @return bool
     */
    public static function matchPaths(string $path, string $routePath): bool
    {
        $pathArray = RouterHelper::explodePath($path);
        $routePathsArray = RouterHelper::explodePath($routePath);

        //If the lengths dont match then its a not match.
        if (count($pathArray) != count($routePathsArray)) {
            return false;
        }

        foreach ($routePathsArray as $key => $part) {
            //If its a wildcard we will just continue onward.
            if (RouterHelper::isWildCard($part)) {
                continue;
            }

            if ($part !== $pathArray[$key]) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $path
     * @return array
     */
    public static function explodePath(string $path): array
    {
        $pathArray = explode('/', $path);
        return array_filter($pathArray, 'strlen');
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function isWildCard(string $string)
    {
        if ($string[0] == '{' and $string[strlen($string)-1] == "}") {
            return true;
        }
        return false;
    }

    /**
     * @param string $string Expected to be separated by ".".
     * @return array
     */
    public static function buildResourcePaths(string $string): array
    {
        $paths = ['index' => '', 'get' => '', 'create' => '', 'update' => '', 'delete' => ''];
        $pathArray = explode('.', $string);
        for ($i = 0; $i < count($pathArray); $i++) {
            $part = $pathArray[$i];
            if ($i == count($pathArray)-1) {
                $paths['index'] .= "/$part";
                $paths['get'] .= "/$part/{id}";
                $paths['create'] .= "/$part";
                $paths['update'] .= "/$part/{id}";
                $paths['delete'] .= "/$part/{id}";
            } else {
                $paths['index'] .= "/$part/{id}";
                $paths['get'] .= "/$part/{id}";
                $paths['create'] .= "/$part/{id}";
                $paths['update'] .= "/$part/{id}";
                $paths['delete'] .= "/$part/{id}";
            }
        }

        return $paths;
    }

}