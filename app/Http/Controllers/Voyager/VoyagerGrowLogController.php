<?php

namespace App\Http\Controllers\Voyager;

use App\Gx\GrowLog;
use App\Gx\GrowLogFeedback;
use App\Role;
use App\User;
use App\Utils\Helpers\Helper;
use Illuminate\Http\Request;
use Voyager;

class VoyagerGrowLogController extends VoyagerController
{
    public function assign(GrowLog $growLog)
    {
      abort_if(!Helper::isAdmin(), 403);
      $data['growLog'] = $growLog;
      $data['title'] = GrowLog::ASSIGN_LOG_TITLE;
      $data['dataType'] = Voyager::model('DataType')->where('slug', '=', 'grow-logs')->first();
      
      return view('voyager::grow-logs.assign')->with($data);
    }
    
    public function postAssign(GrowLog $growLog, Request $request)
    {
      abort_if(!Helper::isAdmin(), 403);
      if($request->get('assigned_to')) {
        $growLog->assigned_to = $request->get('assigned_to');
        $growLog->save();
        
        return redirect('/admin/grow-logs')->with(['message' => 'Grow Log Assigned Successfully']);
      } else {
        session()->flash('required_assigned_to', 'Assign To field is Required');
        return back();
      }
    }
    
    public function giveFeedback(GrowLog $growLog)
    {
      abort_if($growLog->assigned_to !== auth()->id(), 403);
      $data['growLog'] = $growLog;
      $data['logFeedback'] = GrowLogFeedback::whereGrowLogId($growLog->id)->first();
  
      return view('voyager::grow-logs.feedback')->with($data);
    }
    
    public function postFeedback(GrowLog $growLog, Request $request)
    {
      abort_if($growLog->assigned_to !== auth()->id(), 403);
      if($request->get('feedback')) {
        $logFeedback = GrowLogFeedback::whereGrowLogId($growLog->id)->first();
        if(Helper::empty($logFeedback)) {
          $logFeedback = new GrowLogFeedback();
          $logFeedback->grow_log_id = $growLog->id;
          $logFeedback->created_by = auth()->id();
        } else {
          $logFeedback->updated_by = auth()->id();
        }
        $logFeedback->feedback = $request->get('feedback');
        $logFeedback->save();
    
        return redirect('/admin/grow-logs')->with(['message' => 'Feedback Submitted Successfully']);
      } else {
        session()->flash('required_feedback', 'Feedback field is Required');
        return back();
      }
    }
}
