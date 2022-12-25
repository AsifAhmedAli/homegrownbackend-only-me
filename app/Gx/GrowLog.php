<?php

namespace App\Gx;

use App\Actions\GrowLogFeedbackAction;
use App\Role;
use App\User;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GrowLog extends Model
{
    protected $appends = ['weeks', 'days', 'light_cycle', 'dark_cycle'];
    protected $hidden = ['cycle_light', 'updated_at'];
    const ASSIGN_LOG_TITLE = 'Assign Grow Log to Grow Master';
    public const EXCLUDE_ACTIONS = [GrowLogFeedbackAction::class];
    use CommonRelations, CommonScopes, Search;

    public function getWeeksAttribute(): int
    {
      return $this->attributes['expected_days'] / 7;
    }

    public function getDaysAttribute()
    {
      return $this->attributes['expected_days'] % 7;
    }

    public function getLightCycleAttribute()
    {
      return $this->attributes['cycle_light'];
    }

    public function getDarkCycleAttribute()
    {
      return 24 - $this->attributes['cycle_light'];
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function log_details()
    {
        return $this->hasMany(GrowLogDetail::class,'log_id');
    }

    public function strains()
    {
      return $this->belongsToMany(Strain::class);
    }
}
