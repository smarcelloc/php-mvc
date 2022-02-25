<?php

namespace App\Http;

use App\Middleware\Queue as MiddlewareQueue;
use Closure;
use Exception;
use ReflectionFunction;

class Router
{
    private static string $baseUrl;
    private static string $prefix;
    private static array $routes;

    private static array $middleware = [];
    private static array $subMiddleware = [];
    private static Request $request;

    private static string|null $prefixGroup = null;
    private static bool $isGroup = false;

    private static array $routesError = [];

    public static function load(string $baseUrl)
    {
        self::$baseUrl = rtrim($baseUrl, '/');
        self::$request = new Request();
        self::setPrefix();
    }

    private static function setPrefix()
    {
        $urlPath = parse_url(self::$baseUrl, PHP_URL_PATH);
        self::$prefix = $urlPath ?? '';
    }

    public static function get(string $route, Closure $controller)
    {
        self::addRoute('GET', $route, $controller);
    }

    public static function post(string $route, Closure $controller)
    {
        self::addRoute('POST', $route, $controller);
    }

    public static function put(string $route, Closure $controller)
    {
        self::addRoute('PUT', $route, $controller);
    }

    public static function patch(string $route, Closure $controller)
    {
        self::addRoute('PATCH', $route, $controller);
    }

    public static function delete(string $route, Closure $controller)
    {
        self::addRoute('DELETE', $route, $controller);
    }

    public static function options(string $route, Closure $controller)
    {
        self::addRoute('OPTIONS', $route, $controller);
    }

    public static function head(string $route, Closure $controller)
    {
        self::addRoute('HEAD', $route, $controller);
    }

    public static function add(string $method, string $route, Closure $controller)
    {
        self::addRoute(strtoupper($method), $route, $controller);
    }

    public static function match(array $methods, string $route, Closure $controller)
    {
        foreach ($methods as $method) {
            self::addRoute(strtoupper($method), $route, $controller);
        }
    }

    private static function addRoute(string $method, string $route, Closure $controller)
    {
        $route = rtrim($route, '/');

        if (self::$isGroup && !empty(self::$prefixGroup)) {
            $route = self::$prefixGroup . $route;
        }

        $params = [];
        $patternParams = '/{(.*?)}/';
        if (preg_match_all($patternParams, $route, $matches)) {
            $route = preg_replace($patternParams, '(.*?)', $route);
            $params = $matches[1];
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        self::$routes[$patternRoute][$method]['controller'] = $controller;
        self::$routes[$patternRoute][$method]['params'] = $params;
        self::$routes[$patternRoute][$method]['middleware'] = array_merge(self::$middleware, self::$subMiddleware);

        if (self::$isGroup !== true) {
            self::$middleware = [];
        } else {
            self::$subMiddleware = [];
        }
    }

    public static function middleware(array $middleware)
    {
        if (self::$isGroup) {
            self::$subMiddleware = $middleware;
            return new static();
        }

        self::$middleware = $middleware;
        return new static();
    }

    public static function group(string $prefix, Closure $callback)
    {
        self::$prefixGroup = $prefix;
        self::$isGroup = true;

        $callback();

        self::$prefixGroup = null;
        self::$isGroup = false;
        self::$middleware = [];
    }

    public static function setErrors(array $error = [])
    {
        foreach (array_reverse($error) as $route => $controller) {
            $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
            $patternRoute = str_replace('*', '.*', $patternRoute);
            self::$routesError[$patternRoute] = $controller;
        }
    }

    public static function run(): Response
    {
        try {
            $routeCurrent = self::getRouteCurrent();
            $controller = $routeCurrent['controller'];
            $middleware = $routeCurrent['middleware'];
            $request = $routeCurrent['params']['request'];
            $params = self::reflectionRouteParams($controller, $routeCurrent['params']);

            return (new MiddlewareQueue($controller, $params,  $middleware))->next($request);
        } catch (Exception $ex) {
            $code = is_numeric($ex->getCode()) ? intval($ex->getCode()) : 500;

            foreach (self::$routesError as $patternRoute => $controller) {
                if (preg_match($patternRoute, self::getUri())) {
                    return call_user_func_array($controller, [$code, $ex]);
                }
            }

            return new Response($code, $ex->getMessage());
        }
    }

    private static function getRouteCurrent()
    {
        $uri = self::getUri();
        $method = self::$request->getMethod();
        $route = self::validateRoute($uri, $method);

        return $route;
    }

    private static function getUri()
    {
        $uri = self::$request->getUri();

        if (empty(self::$prefix)) {
            return $uri;
        }

        $removePrefixInUri = end(explode(self::$prefix, $uri));
        return $removePrefixInUri;
    }

    private static function validateRoute(string $uri, string $method)
    {
        foreach (self::$routes as $patternRoute => $route) {
            if (preg_match($patternRoute, $uri, $paramsValues)) {
                if (!isset($route[$method])) {
                    throw new Exception("The unauthorized method", 405);
                }

                if (empty($route[$method])) {
                    throw new Exception("The URL could not be processed", 500);
                }

                unset($paramsValues[0]);
                $preventMultipleSlashInParamsEnd = count(explode('/', end($paramsValues))) > 1;
                if ($preventMultipleSlashInParamsEnd) {
                    break;
                }

                return self::routeMap($route[$method], $paramsValues);
            }
        }

        throw new Exception("URL not found", 404);
    }

    private static function routeMap(array $route, array $paramsValues = [])
    {
        $route['params'] = array_combine($route['params'], $paramsValues);
        $route['params']['request'] = self::$request;

        return $route;
    }

    private static function reflectionRouteParams(Closure $controller, array $controllerParams)
    {
        $routeParams = [];
        $reflection = new ReflectionFunction($controller);

        foreach ($reflection->getParameters() as $parameter) {
            $name = $parameter->getName();
            $routeParams[$name] = $controllerParams[$name];
        }

        return $routeParams;
    }
}
