<?php

namespace App\Http\Controllers\Voyager;

use App\Rules\CouponCategoryProductRule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use Voyager;

class VoyagerCouponController extends VoyagerController
{
  /**
   * POST BRE(A)D - Store data.
   *
   * @param Request $request
   *
   * @return RedirectResponse
   * @throws AuthorizationException
   */
  public function store(Request $request)
  {
    $slug = $this->getSlug($request);
    
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    // Check permission
    $this->authorize('add', app($dataType->model_name));
    
    // Validate fields with ajax
    $this->validateBread($request->all(), $dataType->addRows)->validate();
    $request = $this->resolveRequest($request);
    $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
    
    event(new BreadDataAdded($dataType, $data));
    
    if (!$request->has('_tagging')) {
      if (auth()->user()->can('browse', $data)) {
        $redirect = redirect()->route("voyager.{$dataType->slug}.index");
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
  
  // POST BR(E)AD
  public function update(Request $request, $id)
  {
    $slug = $this->getSlug($request);
    
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    // Compatibility with Model binding.
    $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;
    
    $model = app($dataType->model_name);
    if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
      $model = $model->{$dataType->scope}();
    }
    if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
      $data = $model->withTrashed()->findOrFail($id);
    } else {
      $data = $model->findOrFail($id);
    }
    
    // Check permission
    $this->authorize('edit', $data);
    
    // Validate fields with ajax
    $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
    $request = $this->resolveRequest($request);
    $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
    
    event(new BreadDataUpdated($dataType, $data));
    
    if (auth()->user()->can('browse', app($dataType->model_name))) {
      $redirect = redirect()->route("voyager.{$dataType->slug}.index");
    } else {
      $redirect = redirect()->back();
    }
    
    return $redirect->with([
      'message'    => __('voyager::generic.successfully_updated')." {$dataType->getTranslatedAttribute('display_name_singular')}",
      'alert-type' => 'success',
    ]);
  }
  
  public function resolveRequest($request)
  {
    if ($request->type == 'fixed_category' || $request->type == 'percent_category') {
      $request->merge(['coupon_belongstomany_product_relationship' => []]);
    } else if($request->type == 'fixed_product' || $request->type == 'percent_product') {
      $request->merge(['coupon_belongstomany_category_relationship' => []]);
    }
    return $request;
  }
}
