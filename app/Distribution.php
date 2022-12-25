<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use CommonRelations, CommonScopes, Search;
  public function scopeActive(Builder $q)
  {
    $q->whereIsActive(true);
  }
  
  public function getAddressAttribute($value)
  {
    return nl2br($value);
  }
}
