<?php

namespace App\Http\Controllers\Api;

use App\Gx\GxAboutUs;
use App\Utils\Api\ApiResponse;

class GxAboutUsController extends ApiBaseController
{

  /**
   * GrowLogDetailController constructor.
   */
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
      $log_detail = GxAboutUs::find(1);
     if (! is_null($log_detail)) {
         $response['about'] = $log_detail;

         return ApiResponse::success($response);
     }

      $response['about'] = (object) null;
      return ApiResponse::failure($response, 404);
  }

}
