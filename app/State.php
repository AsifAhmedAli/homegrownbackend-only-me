<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use CommonRelations, CommonScopes, Search;
    
    public function scopeSort(Builder $builder)
    {
      $builder->orderBy('name');
    }
    
    public function scopeLegal(Builder $builder)
    {
      $builder->where('is_legal', true);
    }
    public function scopeIllegal(Builder $builder)
    {
      $builder->where('is_legal', false);
    }
}
