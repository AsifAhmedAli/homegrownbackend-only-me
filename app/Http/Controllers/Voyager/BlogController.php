<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Tag;
use App\Utils\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;

class BlogController extends VoyagerController
{
  
  /**
   * POST BRE(A)D - Store data.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $slug = $this->getSlug($request);
    
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    // Check permission
    $this->authorize('add', app($dataType->model_name));
    
    // Validate fields with ajax
    $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
    $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
    
    event(new BreadDataAdded($dataType, $data));
    
    if (!$request->has('_tagging')) {
      if (auth()->user()->can('browse', $data)) {
        $redirect = redirect()->route("voyager.{$dataType->slug}.index");
      } else {
        $redirect = redirect()->back();
      }
      if (isset($data->tags) && !empty($data->tags)) {
        $tagsStr =  Helper::implode(",",json_decode($data->tags));
        $this->saveBlogTagStr($data->id, $tagsStr);
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
    $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
    $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
    
    event(new BreadDataUpdated($dataType, $data));
    
    if (auth()->user()->can('browse', app($dataType->model_name))) {
      $redirect = redirect()->route("voyager.{$dataType->slug}.index");
    } else {
      $redirect = redirect()->back();
    }
    if (isset($data->tags) && !empty($data->tags)) {
      $tagsStr =  Helper::implode(",",json_decode($data->tags));
      $this->saveBlogTagStr($data->id, $tagsStr);
    }
    return $redirect->with([
      'message'    => __('voyager::generic.successfully_updated')." {$dataType->getTranslatedAttribute('display_name_singular')}",
      'alert-type' => 'success',
    ]);
  }
  
  //***************************************
  //                _____
  //               |  __ \
  //               | |__) |
  //               |  _  /
  //               | | \ \
  //               |_|  \_\
  //
  //  Read an item of our Data Type B(R)EAD
  //
  //****************************************
  
  public function show(Request $request, $id)
  {
    $slug = $this->getSlug($request);
    
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    $isSoftDeleted = false;
    
    if (strlen($dataType->model_name) != 0) {
      $model = app($dataType->model_name);
      
      // Use withTrashed() if model uses SoftDeletes and if toggle is selected
      if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
        $model = $model->withTrashed();
      }
      if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
        $model = $model->{$dataType->scope}();
      }
      $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
      if ($dataTypeContent->deleted_at) {
        $isSoftDeleted = true;
      }
    } else {
      // If Model doest exist, get data from table name
      $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
    }
    
    // Replace relationships' keys for labels and create READ links if a slug is provided.
    $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);
    
    // If a column has a relationship associated with it, we do not want to show that field
    $this->removeRelationshipField($dataType, 'read');
    
    // Check permission
    $this->authorize('read', $dataTypeContent);
    
    // Check if BREAD is Translatable
    $isModelTranslatable = is_bread_translatable($dataTypeContent);
    
    // Eagerload Relations
    $this->eagerLoadRelations($dataTypeContent, $dataType, 'read', $isModelTranslatable);
    
    $view = 'voyager::bread.read';
    
    if (view()->exists("voyager::$slug.read")) {
      $view = "voyager::$slug.read";
    }
    $tags = '';
    if (isset($dataTypeContent->tags) && !empty($dataTypeContent->tags)) {
      $tags = Tag::whereIn('id', json_decode($dataTypeContent->tags))->pluck('name')->toArray();
      $tags = Helper::implode(',', $tags);
    }
   
    return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted', 'tags'));
  }
  
  private function saveBlogTagStr($id, $tagsStr): void {
    Blog::whereId($id)->
    update(['tags_str'=>$tagsStr]);
  }
}
