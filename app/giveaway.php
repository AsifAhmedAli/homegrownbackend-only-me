<?php

namespace App;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class giveaway extends Model
{
    use CommonRelations, CommonScopes, Search;
    protected $table = 'giveaway';
    protected $primarykey = 'id';
    public $timestamps = false;
}
