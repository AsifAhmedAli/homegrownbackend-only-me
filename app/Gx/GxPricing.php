<?php

namespace App\Gx;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class GxPricing extends Model
{
    use CommonRelations, CommonScopes, Search;
    
    public function included()
    {
      return $this->hasMany(GxPricingIncluded::class);
    }
}
