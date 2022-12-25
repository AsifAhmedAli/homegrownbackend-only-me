<?php

namespace App\Http\Controllers\Api;

use App\Gx\GrowLog;
use App\Gx\GrowLogDetail;
use App\Http\Controllers\Controller;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class GrowLogDetailController extends ApiBaseController
{
    private $perPage = 20;

    /**
     * GrowLogDetailController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {

        $rules = ValidationRule::growLogDetail();

        $messages = ValidationMessage::growLogDetail();

        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }

        if ($request->get("images")) {
            $images = ApiHelper::uploadGrowLogImages($request->get('images'));
            $request->merge(['images' => json_encode($images)]);
        }

        $inputs = $request->all();
        $inputs["user_id"] = auth()->id();

        GrowLogDetail::create($inputs);

        return ApiResponse::success(trans('generic.grow_log_detail.add'));
    }

    public function edit($id)
    {

        $log_detail = GrowLogDetail::where(["id" => $id, "user_id" => auth()->id()])->first();
        if (!is_null($log_detail)) {
            $log_detail->image = $log_detail->photo;
            $response['log_detail'] = $log_detail;

            return ApiResponse::success($response);
        }
        $response["log_Detail"] = (object)null;
        return ApiResponse::failure($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = ValidationRule::growLogDetail();
        $messages = ValidationMessage::growLogDetail();

        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }

        $log_detail = GrowLogDetail::where(["id" => $id, "user_id" => auth()->id()])->first();

        if (!is_null($log_detail)) {

            if ($request->get("images")) {
                $images = ApiHelper::uploadGrowLogImages($request->get('images'));
                $request->merge(['images' => $images]);
            }

            /*if ($request->get("image")) {
                $request["image"] = ApiHelper::uploadBase64Image($request->image, "grow-log-details", $log_detail->image);
            } else {
                $request["image"] = $log_detail->image;
            }*/

            $inputs = $request->all();
            $inputs["user_id"] = auth()->id();

            $log_detail->update($inputs);

            return ApiResponse::success(trans('generic.grow_log_detail.update'));
        }

        return ApiResponse::failure(trans('generic.grow_log_detail.not_update'));

    }


    public function getGrowLogDetail($grow_log_id, $week, $day = NULL)
    {

        $response = [];
        $log_Detail = GrowLogDetail::with('feedback')->where(["log_id" => $grow_log_id, "user_id" => auth()->id(), "week" => $week, "day" => $day])->first();
        if (!is_null($log_Detail)) {
            $response["log_Detail"] = $log_Detail;

            return ApiResponse::success($response);
        } else {
            return ApiResponse::success(['log_Detail' => null]);
        }

    }

}
