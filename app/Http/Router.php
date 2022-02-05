<?php

namespace App\Http;

use Exception;
use ReflectionFunction;

class Router
{
  private string $prefix;
  private array $routes;
  private Request $request;

  public function __construct(private string $baseUrl)
  {
    $this->setPrefix();
    $this->request = new Request();
  }

  public function run()
  {
    try {
      $route = $this->getRoute();
      $params = $this->defineRouteParams($route);

      $content = call_user_func_array($route['controller'], $params);

      if ($content instanceof Response) {
        return $content;
      }

      return new Response(200, $content);
    } catch (Exception $ex) {
      return new Response($ex->getCode(), $ex->getMessage());
    }
  }

  public function get(string $route, callable $controller)
  {
    $this->addRoute('GET', $route, $controller);
  }

  public function post(string $route, callable $controller)
  {
    $this->addRoute('POST', $route, $controller);
  }

  public function put(string $route, callable $controller)
  {
    $this->addRoute('PUT', $route, $controller);
  }

  public function patch(string $route, callable $controller)
  {
    $this->addRoute('PATCH', $route, $controller);
  }

  public function delete(string $route, callable $controller)
  {
    $this->addRoute('DELETE', $route, $controller);
  }

  private function addRoute(string $method, string $route, callable $controller)
  {
    $params = $this->getRouteParams($route);

    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
    $this->routes[$patternRoute][$method] = $controller;
    $this->routes[$patternRoute]['params'] = $params;
  }

  private function getRouteParams(&$route)
  {
    $patternParams = '/{(.*?)}/';
    if (preg_match_all($patternParams, $route, $matches)) {
      $route = preg_replace($patternParams, '(.*?)', $route);
      return $matches[1];
    }

    return [];
  }

  private function getRoute()
  {
    $uri = $this->getUri();
    $method = $this->request->getMethod();
    $route = $this->validateRoute($uri, $method);

    return $route;
  }

  private function validateRoute(string $uri, string $method)
  {
    foreach ($this->routes as $patternRoute => $route) {
      if (preg_match($patternRoute, $uri, $paramsValues)) {

        if (!isset($route[$method])) {
          throw new Exception('The unauthorized method', 405);
        }

        if (empty($route[$method])) {
          throw new Exception('The URL could not be processed', 500);
        }

        unset($paramsValues[0]);
        $preventMultiParamsInEnd = count(explode('/', end($paramsValues)));
        if ($preventMultiParamsInEnd > 1) {
          break;
        }

        return $this->routeMap($route, $method, $paramsValues);
      }
    }

    throw new Exception('URL not found', 404);
  }

  private function routeMap(array $route, string $method, array $paramsValues)
  {
    $routeMap['controller'] = $route[$method];
    $routeMap['params'] = array_combine($route['params'], $paramsValues);
    $routeMap['params']['request'] = $this->request;

    return $routeMap;
  }

  private function setPrefix()
  {
    $parseUrl = parse_url($this->baseUrl);
    $this->prefix = $parseUrl['path'] ?? '';
  }

  private function getUri()
  {
    $uri = $this->request->getUri();

    if (empty($this->prefix)) {
      return $uri;
    }

    $deletePrefixInUri = end(explode($this->prefix, $uri));
    return $deletePrefixInUri;
  }

  private function defineRouteParams(array $route)
  {
    $params = [];
    $reflaction = new ReflectionFunction($route['controller']);

    foreach ($reflaction->getParameters() as $parameter) {
      $name = $parameter->getName();

      if ($route['params'][$name] === '') {
        throw new Exception('URL not found', 404);
      }

      $params[$name] = $route['params'][$name];
    }

    return $params;
  }
}
