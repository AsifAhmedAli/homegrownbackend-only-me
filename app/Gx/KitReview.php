<?php

namespace App\Gx;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class KitReview extends Model
{
    use CommonRelations, CommonScopes, Search;

}
