<?php

namespace App\Http;

use App\Middleware\Queue as MiddlewareQueue;
use Closure;
use Exception;
use ReflectionFunction;

class Router
{
  private string $prefix;
  private array $routes = [];
  private Request $request;

  public function __construct(private string $baseUrl)
  {
    $this->baseUrl = rtrim($baseUrl, '/');
    $this->setPrefix();
    $this->request = new Request();
  }

  public function run(): Response
  {
    try {
      $route = $this->getRoute();
      $controller = $route['controller'];
      $middleware = $route['middleware'] ?? [];
      $request = $route['params']['request'];
      $params = $this->reflectionRouteParams($controller, $route['params']);

      return (new MiddlewareQueue($controller, $params,  $middleware))->next($request);
    } catch (Exception $ex) {
      $code = is_numeric($ex->getCode()) ? intval($ex->getCode()) : 500;

      return new Response($code, $ex->getMessage());
    }
  }

  public function get(string $route, Closure $controller)
  {
    $this->addRoute('GET', $route, $controller);
    return $this;
  }

  public function post(string $route, Closure $controller)
  {
    $this->addRoute('POST', $route, $controller);
    return $this;
  }

  public function delete(string $route, Closure $controller)
  {
    $this->addRoute('DELETE', $route, $controller);
    return $this;
  }

  public function patch(string $route, Closure $controller)
  {
    $this->addRoute('PATCH', $route, $controller);
    return $this;
  }

  public function put(string $route, Closure $controller)
  {
    $this->addRoute('PUT', $route, $controller);
    return $this;
  }

  public function middleware(array $middleware)
  {
    $patternRoute = array_key_last($this->routes);

    if (is_string($patternRoute)) {
      $this->routes[$patternRoute]['middleware'] = $middleware;
    }
  }

  private function addRoute(string $method, string $route, Closure $controller)
  {
    $params = [];
    $patternParams = '/{(.*?)}/';
    if (preg_match_all($patternParams, $route, $matches)) {
      $route = preg_replace($patternParams, '(.*?)', $route);
      $params = $matches[1];
    }

    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
    $this->routes[$patternRoute][$method] = $controller;
    $this->routes[$patternRoute]['params'] = $params;
  }

  private function setPrefix()
  {
    $parseUrl = parse_url($this->baseUrl);
    $this->prefix = $parseUrl['path'] ?? '';
  }

  private function getRoute()
  {
    $uri = $this->getUri();
    $method = $this->request->getMethod();
    $route = $this->validateRoute($uri, $method);

    return $route;
  }

  private function getUri()
  {
    $uri = $this->request->getUri();

    if (empty($this->prefix)) {
      return $uri;
    }

    $removePrefixInUri = end(explode($this->prefix, $uri));
    return $removePrefixInUri;
  }

  private function validateRoute(string $uri, string $method)
  {
    foreach ($this->routes as $patternRoute => $route) {
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

        return $this->routeMap($route, $method, $paramsValues);
      }
    }

    throw new Exception("URL not found", 404);
  }

  private function routeMap(array $route, string $method, array $paramsValues = [])
  {
    $route['controller'] = $route[$method];
    $route['method'] = $method;
    unset($route[$method]);

    $route['params'] = array_combine($route['params'], $paramsValues);
    $route['params']['request'] = $this->request;

    return $route;
  }

  private function reflectionRouteParams(Closure $controller, array $controllerParams)
  {
    $routeParams = [];
    $reflection = new ReflectionFunction($controller);

    foreach ($reflection->getParameters() as $parameter) {
      $name = $parameter->getName();

      if ($controllerParams[$name] === '') {
        throw new Exception("URL not found", 404);
      }

      $routeParams[$name] = $controllerParams[$name];
    }

    return $routeParams;
  }
}
