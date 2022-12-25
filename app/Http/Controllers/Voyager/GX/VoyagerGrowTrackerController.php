<?php

namespace App\Http\Controllers\Voyager\GX;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Voyager\VoyagerController;
use App\Role;
use App\User;
use App\Utils\Helpers\Helper;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Facades\Voyager;

class VoyagerGrowTrackerController extends VoyagerController
{
  public function store(Request $request)
  {
    $slug = $this->getSlug($request);
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    // Check permission
    $this->authorize('add', app($dataType->model_name));
    
    // Validate fields with ajax
    if(app($dataType->model_name) instanceof User) {
      Helper::checkCreateUserPermissions();
    }
    if(request('source') === 'admins') {
      if(in_array(request('role_id'), Role::adminRoles())) {
        $request->merge(['provider' => 'gx']);
      }
    }
    $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
    $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
    
    event(new BreadDataAdded($dataType, $data));
    
    if (!$request->has('_tagging')) {
      if (auth()->user()->can('browse', $data)) {
        if(request()->has('source')) {
          $redirect = redirect('/admin/' . request('source'));
        } else {
          $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        }
      } else {
        $redirect = redirect()->back();
      }
      return $redirect->with([
        'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
        'alert-type' => 'success',
      ]);
    } else {
      return response()->json(['success' => true, 'data' => $data]);
    }
  }
}
