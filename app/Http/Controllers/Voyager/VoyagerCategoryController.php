<?php

namespace App\Http\Controllers\Voyager;

use App\Rules\CategoryUniqueRule;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;

class VoyagerCategoryController extends VoyagerController
{
  /**
   * POST BRE(A)D - Store data.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Illuminate\Auth\Access\AuthorizationException
   */
  public function store(Request $request)
  {
    $slug = $this->getSlug($request);
  
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
  
    // Check permission
    $this->authorize('add', app($dataType->model_name));
  
    // Validate fields with ajax
    $rules = [
      'title' => ['required', 'max:191', new CategoryUniqueRule()]
    ];
    Validator::make($request->all(), $rules, [] , ['title' => 'Title'])->validate();
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
    $rules = [
      'title' => ['required', 'max:191', new CategoryUniqueRule($id)]
    ];
    Validator::make($request->all(), $rules, [] , ['title' => 'Title'])->validate();
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
}
