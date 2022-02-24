<?php

namespace App\Http;

use Exception;

class Response
{
  private array $headers = [];

  public function __construct(private int $code, private mixed $content, private string $contentType = RESPONSE_HTML)
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
      case RESPONSE_HTML:
        $this->sendTextHtml();
        exit;

      case RESPONSE_JSON:
        $this->sendAppJson();
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

  private function sendAppJson()
  {
    echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  }
}
