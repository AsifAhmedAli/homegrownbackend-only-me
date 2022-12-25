<?php

namespace App\Models;

use App\PaypalPlan;
use App\User;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $guarded = [];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(PaypalPlan::class,'paypal_plan_id');
    }
}
