<?php

namespace App\Models;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use CommonRelations, CommonScopes, Search;

}
