<?php

namespace App\Utils;

class Pagination
{
  private int $totalPage;

  public function __construct(
    private int $count,
    private int $currentPage = 1,
    private int $limit = 2
  ) {
    $this->currentPage = $this->currentPage > 0 ? $this->currentPage : 1;
    $this->calculate();
  }

  public function getLimit()
  {
    return $this->limit;
  }

  public function getOffset()
  {
    return $this->limit * ($this->currentPage - 1);
  }

  public function getPages()
  {
    if ($this->totalPage === 1) {
      return [];
    }

    $pages = [];
    for ($i = 1; $i <= $this->totalPage; $i++) {
      $pages[] = [
        'page' => $i,
        'current' => $i === $this->currentPage
      ];
    }

    return $pages;
  }

  private function calculate()
  {
    $this->totalPage = $this->count > 0 ? ceil($this->count / $this->limit) : 1;
    $this->currentPage = $this->currentPage > $this->totalPage ? $this->totalPage : $this->currentPage;
  }
}
