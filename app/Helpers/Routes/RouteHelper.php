<?php

namespace App\Helpers\Routes;

class RouteHelper
{
    public static function includeRouteFiles(string $routes)
    {
        foreach (glob($routes . '/*.php') as $filename) {

            if (is_readable($filename)) require $filename;
        }
    }

}
