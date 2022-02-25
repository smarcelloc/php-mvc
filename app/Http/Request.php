<?php

namespace App\Http;

class Request
{
  private string $method;
  private string $uri;
  private array $headers;
  private array $params;
  private array $posts;
  private array $files;

  public function __construct()
  {
    $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->setUri();
    $this->headers = getallheaders() ?? [];
    $this->params = $_GET ?? [];
    $this->setPosts();
    $this->files = $_FILES ?? [];
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getUri()
  {
    return $this->uri;
  }

  public function getHeaders(?string $key = null, mixed $defaultValue = null)
  {
    if (is_null($key)) {
      return $this->headers;
    }

    return $this->headers[$key] ?? $defaultValue;
  }

  public function getParams(?string $key = null, mixed $defaultValue = null)
  {
    if (is_null($key)) {
      return $this->params;
    }

    return $this->params[$key] ?? $defaultValue;
  }

  public function getPosts(?string $key = null, mixed $defaultValue = null)
  {
    if (is_null($key)) {
      return $this->posts;
    }

    return $this->posts[$key] ?? $defaultValue;
  }

  private function setPosts()
  {
    if (!empty($_POST)) {
      $this->posts = $_POST;
    } else {
      $inputRaw = file_get_contents('php://input');
      $this->posts = strlen($inputRaw) ? json_decode($inputRaw, true) : [];
    }
  }

  public function getFiles(?string $key = null, mixed $defaultValue = null)
  {
    if (is_null($key)) {
      return $this->files;
    }

    return $this->files[$key] ?? $defaultValue;
  }

  private function setUri()
  {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $uriSanitize = filter_var(rtrim($uri, '/'), FILTER_SANITIZE_URL);
    $removeParamsInUri = explode('?', $uriSanitize)[0];

    $this->uri = $removeParamsInUri;
  }

  public function getBodyJson()
  {
  }

  public function setBodyJson()
  {
    $body = file_get_contents('php://input');
    $this->json = json_decode($body, true);
  }
}
