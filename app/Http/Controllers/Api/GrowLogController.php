<?php

namespace App\Http\Controllers\Api;

use App\Gx\GrowLog;
use App\Role;
use App\User;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use App\Utils\Helpers\Helper;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GrowLogController extends ApiBaseController
{
  private $perPage = 20;

  /**
   * GrowLogController constructor.
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @return GrowLog|Model|Eloquent
   */
  private function baseQuery()
  {
    return GrowLog::ofUser($this->getUserID());
  }

  /**
   * @return JsonResponse
   */
  public function index()
  {
    $response['logs']      = $this->baseQuery()->latest('id')->paginate($this->perPage);
    $response['activeLog'] = $this->baseQuery()->where('is_active', 1)->exists();
    $response["hasSubscription"] = ApiHelper::hasSubscription();
    if ($this->isAssignedGrowMaster()){
      $response['assignGrowMaster'] = true;
    }else{
      $response['assignGrowMaster'] = false;
    }
    return ApiResponse::success($response);
  }


  /**
   * @return boolean
   */
  public function hasActiveLog()
  {
    return $this->baseQuery()->active()->exists();
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function add(Request $request)
  {
    $rules = ValidationRule::growLog();

    $messages = ValidationMessage::growLog();

    try {
      $this->validate($request, $rules, $messages);
    } catch (ValidationException $e) {
      return ApiResponse::validation($e->errors());
    }

    if($this->hasActiveLog()) {
      return ApiResponse::failure('You already have an active log!', 400);
    }

   /* if (! $this->isAssignedGrowMaster()) {
        return ApiResponse::failure("You can't create growlog!", 400);
    }*/

    $log = new GrowLog();
    $log->user_id = $this->getUserID();
    $log = $this->save($log, $request);

    $log->strains()->sync(request('strain', []));

    return ApiResponse::success('Growlog created successfully.');
  }

  private function isAssignedGrowMaster() {

      $user = User::with("assignee:id,role_id")
          ->select("id", "name", "assigned_to")
          ->find(auth()->id());

      if (! is_null($user) && in_array(@$user->assignee->role_id, Role::growOperators())) {
          return true;
     }
      return false;
  }

  /**
   * @param $id
   * @return JsonResponse
   */
  public function deActivate($id)
  {
    $log = $this->baseQuery()->findOrFail($id);

    $log->is_active = false;
    $log->save();

    return ApiResponse::success('Growlog inactive successfully.');
  }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function complete($id)
    {
        $log = $this->baseQuery()->findOrFail($id);
        $log->is_active = false;
        $log->status = 1;
        $log->save();

        return ApiResponse::success('Growlog completed successfully.');
    }

  public function show($id)
  {
    $response['log'] = $this->baseQuery()->findOrFail($id);

    return ApiResponse::success($response);
  }

  /**
   * @param Request $request
   * @param $id
   * @return JsonResponse
   */
  public function update(Request $request, $id)
  {
    $rules = [
      'expectedDaysWeeks' => 'required'
    ];

    $messages = ValidationMessage::growLog();

    try {
      $this->validate($request, $rules, $messages);
    } catch (ValidationException $e) {
      return ApiResponse::validation($e->errors());
    }

    $log = $this->baseQuery()->active()->findOrFail($id);
//    $log->expected_days = ($request->get('expectedDaysWeeks', 1) * 7) +  $request->get('expectedDays', 0);
    $log->expected_days = $request->get('expectedDaysWeeks');
    $log->tent_size = $request->get('tentSize');
    $log->nutrients = $request->get('nutrients');
    $log->save();


    return ApiResponse::success('Growlog updated successfully.');
  }

  /**
   * @param GrowLog $log
   * @param Request $request
   * @return GrowLog
   */
  private function save(GrowLog $log, Request $request)
  {
    $isUpdate = isset($log->id);

    $log->plant_name = $request->get('plantName', $isUpdate ? $log->plant_name : null);
    $log->stage = $request->get('stage');
    $log->started_at = $request->get('startedAt');
//    $log->expected_days = ($request->get('expectedDaysWeeks', 1) * 7) +  $request->get('expectedDays', 0);
    $log->expected_days = $request->get('expectedDaysWeeks');
    $log->lighting = $request->get('lighting');
    $log->cycle_light = $request->get('cycleLight', 0) ?? 0;
    $log->lighting_type_id = $request->get('lightingType');
    $log->wattage = $request->get('wattage');
    $log->media_type_id = $request->get('mediaType');
    $log->tent_size = $request->get('tentSize');
    $log->nutrients = $request->get('nutrients');
    $log->kit_id = $request->get('kit_id');
    if(!$isUpdate) {
      $log->is_active = true;
    }
    $log->save();

    return $log;
  }

  public function growLogExpectedWeeks($grow_log_id) {
      $response = [];

      $grow_log = GrowLog::with('strains')->whereUserId(auth()->id())->find($grow_log_id);
      if($grow_log) {
          $weeksDays = ApiHelper::growLogExpectedDaysWeek($grow_log);
          $response["expected_weeks"] = $weeksDays[0];
          $response["days"] = $weeksDays[1];
          $currentWeek = now()->diffInWeeks(Carbon::parse($grow_log->started_at));
          $currentWeek = $currentWeek === 0 ? 1 : $currentWeek;
          $expectedDate = Carbon::parse($grow_log->started_at)->addDays($grow_log->expected_days);
          $response['showCompletedBtn'] = now() >= $expectedDate;
          $response["current_week"] = $currentWeek > 24 ? Helper::ordinal(24) : Helper::ordinal($currentWeek);
          $response["current_date"] = now()->format('yy-m-d');
          $response["start_of_week"] = now()->startOfWeek()->format('yy-m-d');
          $response["end_of_week"] = now()->endOfWeek()->format('yy-m-d');

          $response['grow_log'] = $grow_log;
          return ApiResponse::success($response);
      } else {
          return ApiResponse::failure('No Log found', 404);
      }

  }

}
