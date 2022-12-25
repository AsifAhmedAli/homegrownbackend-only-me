<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
  use CommonRelations, CommonScopes, Search;
  const HGP = 'hgp';
  const GX = 'gx';
  public function scopeHowItWork(Builder $q)
  {
    $q->whereShowOnHowItWork(true);
  }
  
  public function scopeFeature(Builder $q)
  {
    $q->whereIsFeature(true);
  }
  
  public function scopeOfType($query, $type)
  {
    if ($type == Faq::HGP) {
      return $query->where('show_on_hgp_project', 1);
    }else {
      return $query->where('show_on_gx_project', 1);
    }
  }
  
  
}
