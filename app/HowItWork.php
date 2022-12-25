<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HowItWork extends Model
{
    protected $table = 'how_it_work';
    use CommonRelations, CommonScopes, Search;
    
    public function scopeActive(Builder $q)
    {
      $q->whereIsActive(true);
    }
}
