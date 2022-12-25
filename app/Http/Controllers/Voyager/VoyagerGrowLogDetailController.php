<?php

namespace App\Http\Controllers\Voyager;

use App\Gx\GrowLogDetail;
use App\Gx\GrowLogFeedback;
use Illuminate\Http\Request;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;

class VoyagerGrowLogDetailController extends VoyagerController
{
    public function giveFeedback(GrowLogDetail $growLogDetail)
    {
        //abort_if($growLogDetail->assigned_to !== auth()->id(), 403);
        $data['growLogDetail'] = $growLogDetail;
        $data['logFeedback'] = GrowLogFeedback::whereGrowLogDetailId($growLogDetail->id)->first();

        return view('voyager::grow-log-details.feedback')->with($data);
    }

    public function postFeedback(GrowLogDetail $growLogDetail, Request $request)
    {
        //abort_if($growLog->assigned_to !== auth()->id(), 403);
        if($request->get('feedback')) {
            $logFeedback = GrowLogFeedback::whereGrowLogDetailId($growLogDetail->id)->first();
            if(Helper::empty($logFeedback)) {
                $logFeedback = new GrowLogFeedback();
                $logFeedback->grow_log_detail_id = $growLogDetail->id;
                $logFeedback->created_by = auth()->id();
            } else {
                $logFeedback->updated_by = auth()->id();
            }
            $logFeedback->feedback = $request->get('feedback');
            $logFeedback->save();

            return redirect('/admin/grow-log-details')->with(['message' => 'Feedback Submitted Successfully']);
        } else {
            session()->flash('required_feedback', 'Feedback field is Required');
            return back();
        }
    }

}
