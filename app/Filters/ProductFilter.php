<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilter
{
  public function apply(Builder $query, Request $request)
  {
    if ($request->has('category_id')) {
      $query->where('category_id', $request->category_id);
    }
    return $query;
  }
}
