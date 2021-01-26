<?php

namespace App\Context;

use Illuminate\Pagination\Paginator;

trait HasPaginate
{
  protected $request;
  protected $data;

  public function toPagination()
  {
    $request = $this->request;

    $page = 1;
    $perPage = 10;

    if ($request && $request->has('page')) {
      $page = $request->page;
    }

    if ($request && $request->has('size')) {
      $perPage = $request->size;
    }

    Paginator::currentPageResolver(function () use ($page) {
      return $page;
    });

    return $this->data->paginate($perPage);
  }
}
