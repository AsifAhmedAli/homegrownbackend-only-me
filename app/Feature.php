<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use CommonRelations, CommonScopes, Search;
    public function sections(){
      return $this->hasMany(FeatureSection::class);
    }
    public function icons(){
      return $this->hasMany(FeatureIcon::class);
    }
}
