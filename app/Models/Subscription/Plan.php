<?php

namespace App\Models\Subscription;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\RestoreAction;

class Plan extends Model
{
    use CommonRelations, CommonScopes, Search;
    public const EXCLUDE_ACTIONS = [DeleteAction::class, RestoreAction::class];
    public const SHOW_BULK_CHECKBOX = false;
    public const CAN_ADD_NEW = false;
    public const CAN_BULK_DELETE = false;
    
    public static function findByPlan($planID)
    {
      return static::wherePlanId($planID)->firstOrFail();
    }
    
    public function scopeAnnual($query, $opposite = true)
    {
      if($opposite) {
        $query->where('billing_frequency', 12);
      } else {
        $query->where('billing_frequency', '!=', 12);
      }
    }
}
