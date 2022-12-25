<?php
  
  namespace App;
  use App\Utils\Helpers\Helper;
  use App\Utils\Traits\CommonRelations;
  use App\Utils\Traits\CommonScopes;
  use App\Utils\Traits\Search;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Database\Eloquent\Model;
  
  class PaypalPlan extends Model
  {
    use CommonRelations, CommonScopes, Search;
    public const CAN_BULK_DELETE    = false;
    public const SHOW_BULK_CHECKBOX = false;
    
    const ACTIVE = "ACTIVE";
    const INACTIVE = "INACTIVE";
  
    public function setFeaturesAttribute($value)
    {
      $this->attributes['features'] = Helper::getTagsValues($value);
    }

    public function scopeStatus(Builder $q, $status)
    {
      $q->whereState($status);
    }
    
    public function scopeActive(Builder $builder)
    {
      $builder->whereState(self::ACTIVE);
    }
  }
