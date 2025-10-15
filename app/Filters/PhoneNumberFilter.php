<?php

namespace App\Filters;

use App\Traits\HasIncludeRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PhoneNumberFilter
{
  use HasIncludeRule;
  public function apply(Builder $query, Request $request)
  {
    if ($request->type ?? null) {
      $type = $this->includeStrToArray($request->type);
      $query->whereJsonContains('type', $type);
    }
    return $query
      // [
      //   'query' => $query,
      //   'type' => $type ?? null,
      // ]
    ;
  }
}
