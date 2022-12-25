<?php

namespace App\Models;

use App\Hydro\HydroCategory;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class FeaturedCategory extends Model
{
    use CommonRelations, CommonScopes, Search;

    public function hydro_category() {
        return $this->belongsTo(HydroCategory::class);
    }
}
