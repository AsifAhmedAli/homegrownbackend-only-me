<?php

namespace App\Http\Controllers\Voyager;

use App\Hydro\HydroProduct;
use App\Utils\Helpers\Helper;
use Braintree\Error\Validation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;
use TCG\Voyager\Events\BreadDataUpdated;
use Voyager;

class VoyagerHydroProductController extends VoyagerController
{
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
    if($this->verifyMaxFeatured($data->id)) {
      session()->flash('featured_error', "Only " . HydroProduct::MAX_FEATURED_ALLOWED . " featured products are allowed");
      return back();
    }
    if($this->verifyMaxBannerProducts($data->id)) {
      session()->flash('featured_error', "Only " . HydroProduct::MAX_BANNER_PRODUCTS_ALLOWED . " Banner Products are allowed");
      return back();
    }
    if(!$this->verifyBannerImage($data)) {
      session()->flash('featured_error', "Featured Image is Required");
      return back();
    }
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
  
  private function verifyMaxFeatured($id)
  {
    if(request()->has('is_featured') && request('is_featured') == 'on') {
      return HydroProduct::whereIsFeatured(true)->where('id', '!=', $id)->count() >= HydroProduct::MAX_FEATURED_ALLOWED;
    }
    
    return false;
  }
  
  private function verifyMaxBannerProducts($id)
  {
    if(request()->has('is_banner_product') && request('is_banner_product') == 'on') {
      return HydroProduct::where('is_banner_product', true)->where('id', '!=', $id)->count() >= HydroProduct::MAX_BANNER_PRODUCTS_ALLOWED;
    }
    
    return false;
  }
  
  private function verifyBannerImage(HydroProduct $hydroProduct)
  {
    if(request()->has('is_banner_product') && request('is_banner_product') == 'on') {
      if(!Helper::empty($hydroProduct->featured_image)) {
        return true;
      }
      return request()->has('featured_image');
    }
    
    return true;
  }
}
