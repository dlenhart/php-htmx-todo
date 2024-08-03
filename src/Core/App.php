<?php

namespace App\Core;

use Exception;
use App\Constants;


class App implements Interfaces\AppInterface
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static function initialize(): static
    {
        return new static;
    }

    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post(string $uri, string $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function put(string $uri, string $controller): void
    {
        $this->routes['PUT'][$uri] = $controller;
    }

    public function delete(string $uri, string $controller): void
    {
        $this->routes['DELETE'][$uri] = $controller;
    }

    public function run(): mixed
    {
        $uri = $this->uri();
        $httpMethod = $this->method();

        if (!isset($this->routes[$httpMethod])) {
            return Response::notFound(Constants::NOT_ALLOWED_MESSAGE, 405);
        }

        if ($this->validateUrlMethod($uri, $httpMethod)) {
            [$controller, $method] = $this->splitControllerAndMethod($httpMethod, $uri,);
            try {
                return $this->dispatch($controller, $method);
            } catch (Exception $e) {
            }
        }

        return Response::notFound(Constants::NOT_FOUND_MESSAGE, 404);
    }

    /**
     * @throws Exception
     */
    protected function dispatch(string $controller, string $method): mixed
    {
        $callController = "App\\Controllers\\{$controller}";

        try {
            $callController = new $callController();
        } catch (Exception $e) {
            throw new Exception(
                "Unable to instantiate {$controller} - {$e}"
            );
        }

        if (!method_exists($callController, $method)) {
            throw new Exception(
                "{$controller} is unable to call the '{$method}' method, does it exist?!"
            );
        }

        return $callController->$method();
    }

    private function validateUrlMethod(string $uri, string $method): bool
    {
        return array_key_exists($uri, $this->routes[$method]);
    }

    private function splitControllerAndMethod(string $httpMethod, string $uri): array
    {
        $string = explode('@', $this->routes[$httpMethod][$uri]);
        return [$string[0], $string[1]];
    }

    private function uri(): string
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    private function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
