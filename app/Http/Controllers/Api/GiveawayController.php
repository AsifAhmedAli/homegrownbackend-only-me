<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\giveaway;
use App\Mail\GiveawayThankyou;
use App\Utils\Api\ApiResponse;
use Illuminate\Support\Facades\Mail;
// sftp://ubuntu@54.91.16.114/var/www/html/backend/app/giveaway.php
class GiveawayController extends Controller
{
    function save1(Request $request){
        $data = new giveaway();
        $data->name = $request->get('name');
        $data->email = $request->get('email');
        $data->instagramhandle = $request->get('instagramHandle');
        $data->state = $request->get('state');
        $data->age = $request->get('age');
        $data->describe = $request->get('describe');
        $data->interest = $request->get('interest');
        $data->hear = $request->get('hear');
        $data->number = $request->get('number');
        $data->created_on = date("Y-m-d h:i:sa");
        $match = giveaway::where('email', $data->email)->count();
        if($match > 0){
            return ApiResponse::errorResponse(__('generic.error'),"Duplicate Email Address");
        }
        else{
            $data->save();
            $body = "
            Lets Growww!
            <br><br><br>
            Thank you for registering in our launch day MambaLine giveaway. Congratulations, you are now officially eligible to win our game changing, trailblazing, MambaLine GrowKit. Not only that, but you now have multiple chances to win weekly prizes from some of the dopest companies in the industry. Together we are changing the game. We would wish you luck, but here at HomeGrown Pros, we believe you can grow your own.
            <br>
            WANT TO DOUBLE YOUR CHANCES TO WIN? 
            <br>
            <br>
            It’s easy…
            <br>
            <br>
            Share any of our social media giveaway post on Instagram @homegrownpros.io and tag 3 growers or wannabe growers for one (1) extra entry into our MambaLine giveaway. 
            <br>
            <br>
            Hey, Thanks again for your registration. We look forward to guiding you on your grow journey.
            <br>
            <br>
            Happiness and Growth, 
            <br>
            <br>
            Your HomeGrown Team. 💚
            <br>www.HomeGrownPros.io
            <br>
            <br>
            <br>
            CTA # 1—Need the Mambaline <a href='https://calendly.com/hgpros/growpro-consultation-free-clone'>GrowKit now</a>? Secure yours with as little as $500 down, and be first in line in your cannabis state.
            <br>
            <br>
            <br>
            CTA # 2—Need our team of GrowPros we are here to help you on your grow journey. <a href='https://calendly.com/hgpros/growpro-consultation-free-clone'>Click here</a> to schedule your a free GrowPro consultation to see what Growkit line and grow method is right for you and get max Early Bird Specials. (Update link to calendly) 
            <br>
            <br>
            <br>
            ***Must email a screenshot of your share and tags to <a href='https://I.shared@thehomegrownpros.com'>I.shared@thehomegrownpros.com</a> to be credited with one (1) additional entry. It’s that easy, show us some love and double your chances.
            ";
            Mail::to($data->email)->send(new GiveawayThankyou($data->name, $body));
            return ApiResponse::successResponse(__('generic.success'), $data);
        }        
    }   
}
