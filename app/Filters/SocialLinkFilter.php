<?php

namespace App\Filters;

use App\Traits\HasIncludeRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SocialLinkFilter
{
  use HasIncludeRule;
  public function apply(Builder $query, Request $request)
  {
    if ($request->social_media ?? null) {
      $social_media = $this->includeStrToArray($request->social_media);
      $query->where('social_media', $social_media);
    }
    return $query;
  }
}
