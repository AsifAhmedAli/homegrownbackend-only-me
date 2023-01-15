<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\giveaway;
use App\Utils\Api\ApiResponse;
// sftp://ubuntu@54.91.16.114/var/www/html/backend/app/giveaway.php
class GiveawayController extends Controller
{
    function save1(Request $request){
        $data = new giveaway();
        $data->name = $request->get('name');
        $data->email = $request->get('email');
        $data->instagramhandle = $request->get('instagramHandle');
        $data->state = $request->get('state');
        $data->describe = $request->get('describe');
        $data->interest = $request->get('interest');

        $match = giveaway::where('email', $data->email)->count();
        if($match > 0){
            return ApiResponse::errorResponse(__('generic.error'),"Duplicate Email Address");
        }
        else{
            $data->save();
            return ApiResponse::successResponse(__('generic.success'), $data);
        }        
    }   
}
