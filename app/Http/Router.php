<?php

namespace App\Http;

use Exception;

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
      $controller = $this->getRoute();

      $content = call_user_func_array($controller, []);

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

  private function addRoute(string $method, string $route, callable $controller)
  {
    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
    $this->routes[$patternRoute][$method] = $controller;
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
      if (preg_match($patternRoute, $uri)) {

        if (!isset($route[$method])) {
          throw new Exception('The unauthorized method', 405);
        }

        if (empty($route[$method])) {
          throw new Exception('The URL could not be processed', 500);
        }

        return $route[$method];
      }
    }

    throw new Exception('URL not found', 404);
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
}
