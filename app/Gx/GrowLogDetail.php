<?php

namespace App\Gx;

use App\Actions\GrowLogDetailFeedbackAction;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\EditAction;
use TCG\Voyager\Actions\RestoreAction;

class GrowLogDetail extends Model
{
    protected $fillable = [
        'day','images', 'log_id', 'user_id', 'week', 'image', 'high_temprature', 'low_temprature', 'temprature_unit', 'high_humidity', 'low_humidity',
        'high_co2','low_co2' , 'high_water_volume', 'low_water_volume', 'water_ph', 'water_strength', 'water_temprature',
        'runoff', 'runoff_unit', 'runoff_water_strength', 'runoff_water_strength_unit', 'runoff_ph', 'note'
    ];
    protected $hidden = ['updated_at'];

    use CommonRelations, CommonScopes, Search;

    public const EXCLUDE_ACTIONS = [DeleteAction::class, RestoreAction::class, EditAction::class, GrowLogDetailFeedbackAction::class];
    public const SHOW_BULK_CHECKBOX = false;
    public const CAN_ADD_NEW = false;
    public const CAN_BULK_DELETE = false;

//    public $casts = [
//      'images' => 'array'
//    ];
    public function getPhotoAttribute()
    {
        if (isset($this->attributes['image'])) {
            return asset("storage").'/'.$this->attributes['image'];
        }

        return "";
    }

    public function feedback()
    {
      return $this->hasMany(GrowLogFeedback::class, 'grow_log_detail_id');
    }


}
