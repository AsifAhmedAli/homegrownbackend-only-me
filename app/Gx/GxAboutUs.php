<?php

namespace App\Gx;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class GxAboutUs extends Model
{
    use CommonRelations, CommonScopes, Search;

    public function getMainPhotoAttribute()
    {
        if (isset($this->attributes['main_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['main_image'];
        }

        return "";
    }

    public function getSection1PhotoAttribute()
    {
        if (isset($this->attributes['section_1_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_1_image'];
        }

        return "";
    }

    public function getSection2PhotoAttribute()
    {
        if (isset($this->attributes['section_2_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_2_image'];
        }

        return "";
    }

    public function getSection3PhotoAttribute()
    {
        if (isset($this->attributes['section_3_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_3_image'];
        }

        return "";
    }

    public function getSection4PhotoAttribute()
    {
        if (isset($this->attributes['section_4_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_4_image'];
        }

        return "";
    }

    public function getSection5PhotoAttribute()
    {
        if (isset($this->attributes['section_5_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_5_image'];
        }

        return "";
    }

    public function getSection6PhotoAttribute()
    {
        if (isset($this->attributes['section_6_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_6_image'];
        }

        return "";
    }

    public function getSection7PhotoAttribute()
    {
        if (isset($this->attributes['section_7_image'])) {
            return asset("storage/app/public").'/'.$this->attributes['section_7_image'];
        }

        return "";
    }
}
