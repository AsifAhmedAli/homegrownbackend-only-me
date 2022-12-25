<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GrowTracker;
use App\Traits\HasCrudActions;
use Illuminate\Http\Request;

class GrowTrackerController extends Controller
{
    use HasCrudActions;

    protected $model = GrowTracker::class;

}
