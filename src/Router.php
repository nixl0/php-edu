<?php

namespace Nilixin\Edu;

use Exception;

class Router
{
    private array $routes;

    public function register(string $route, callable|array $action)
    {
        $this->routes[$route] = $action;

        return $this;
    }

    public function resolve(string $requestUri)
    {
        $route = explode("?", $requestUri)[0];

        $action = $this->routes[$route] ?? null;

        if (! $action) {
            throw new Exception("Route not found");
        }

        return call_user_func($action);
    }

}