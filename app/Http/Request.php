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
    $this->headers = array_change_key_case(getallheaders(), CASE_LOWER) ?? [];
    $this->params = array_change_key_case($_GET, CASE_LOWER) ?? [];
    $this->setPosts();
    $this->files = array_change_key_case($_FILES, CASE_LOWER) ?? [];
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
    return $this->foundKeyArray($this->headers, $key, $defaultValue);
  }

  public function getParams(?string $key = null, mixed $defaultValue = null)
  {
    return $this->foundKeyArray($this->params, $key, $defaultValue);
  }

  public function getPosts(?string $key = null, mixed $defaultValue = null)
  {
    return $this->foundKeyArray($this->posts, $key, $defaultValue);
  }

  private function setPosts()
  {
    if (!empty($_POST)) {
      $this->posts = $_POST;
    } else {
      $inputRaw = file_get_contents('php://input');
      $this->posts = strlen($inputRaw) ? json_decode($inputRaw, true) : [];
    }

    $this->posts = array_change_key_case($this->posts, CASE_LOWER);
  }

  public function getFiles(?string $key = null, mixed $defaultValue = null)
  {
    return $this->foundKeyArray($this->files, $key, $defaultValue);
  }

  private function setUri()
  {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $uriSanitize = filter_var(rtrim($uri, '/'), FILTER_SANITIZE_URL);
    $removeParamsInUri = explode('?', $uriSanitize)[0];

    $this->uri = $removeParamsInUri;
  }

  private function foundKeyArray(array $array, ?string $key = null, mixed $defaultValue = null)
  {
    if (is_null($key)) {
      return $array;
    }

    return $array[strtolower($key)] ?? $defaultValue;
  }
}
