<?php

namespace Nilixin\Edu;

use Exception;

class Router
{
    private array $routes;

    public function getRoutes()
    {
        return $this->routes;
    }

    public function register(string $requestMethod, string $route, callable|array $action)
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action)
    {
        return $this->register("GET", $route, $action);
    }

    public function post(string $route, callable|array $action)
    {
        return $this->register("POST", $route, $action);
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        // отделение адреса из uri строки
        $route = explode("?", $requestUri)[0];

        // сопоставление адреса с путем
        $action = $this->routes[$requestMethod][$route] ?? null;

        // если путь не найден, то исключение
        if (! $action) {
            throw new Exception("Route not found");
        }

        // если путь является функцией, то вызов функции
        if (is_callable($action)) {
            return call_user_func($action);
        }

        // если путь является массивом из класса и метода
        if (is_array($action)) {
            // разложение пути на класс и метод
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        // если не удалось разобрать содержимое uri, то исключение
        throw new Exception("Route not found");
    }

}