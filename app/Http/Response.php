<?php

namespace App\Http;

use Exception;

class Response
{
  private array $headers = [];

  public function __construct(private int $code, private string $content, private string $contentType = 'text/html')
  {
    $this->addHeaders(['ContentType' => $contentType]);
  }

  public function addHeaders(array $headers)
  {
    foreach ($headers as $key => $value) {
      $this->headers[$key] = $value;
    }
  }

  public function send()
  {
    $this->sendHeaders();

    switch ($this->contentType) {
      case 'text/html':
        $this->sendTextHtml();
        exit;

      default:
        throw new Exception("We can't render this type of content {$this->contentType}");
    }
  }

  private function sendHeaders()
  {
    http_response_code($this->code);

    foreach ($this->headers as $key => $value) {
      header("{$key}:{$value}");
    }
  }

  private function sendTextHtml()
  {
    echo $this->content;
  }
}
