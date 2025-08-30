<?php
namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    public function get(string $pattern, callable|array $handler): void { $this->add('GET', $pattern, $handler); }
    public function post(string $pattern, callable|array $handler): void { $this->add('POST', $pattern, $handler); }
    public function put(string $pattern, callable|array $handler): void { $this->add('PUT', $pattern, $handler); }
    public function delete(string $pattern, callable|array $handler): void { $this->add('DELETE', $pattern, $handler); }

    private function add(string $method, string $pattern, $handler): void
    {
        $this->routes[$method][] = [$this->compile($pattern), $handler, $pattern];
    }

    private function compile(string $pattern): array
    {
        $paramNames = [];
        $regex = preg_replace_callback('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', function($m) use (&$paramNames) {
            $paramNames[] = $m[1];
            return '([A-Za-z0-9\-\_]+)';
        }, $pattern);
        $regex = '#^' . $regex . '$#';
        return [$regex, $paramNames];
    }

    public function dispatch(string $method, string $path): void
    {
        $method = strtoupper($method);
        $path = rtrim($path, '/') ?: '/';
        foreach ($this->routes[$method] ?? [] as [$compiled, $handler, $pattern]) {
            [$regex, $params] = $compiled;
            if (preg_match($regex, $path, $m)) {
                array_shift($m);
                $args = array_combine($params, $m) ?: [];
                $this->invoke($handler, $args);
                return;
            }
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    private function invoke(callable|array $handler, array $args): void
    {
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $instance = new $class();
            $instance->$method(...array_values($args));
        } else {
            $handler(...array_values($args));
        }
    }
}
