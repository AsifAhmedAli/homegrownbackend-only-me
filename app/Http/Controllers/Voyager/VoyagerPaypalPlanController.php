<?php

namespace App\Http\Controllers\Voyager;

use App\PaypalPlan;
use App\Repositories\Paypal\Subscription\PaypalPlanService;
use App\Role;
use App\User;
use Auth;
use App\Utils\Constants\Constant;
use App\Utils\Constants\Paypal;
use App\Utils\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;

class VoyagerPaypalPlanController extends VoyagerController
{
  /**
   * @var PaypalPlanService
   */
  private $paypalPlanService;
  
  public function __construct(PaypalPlanService $paypalPlanService){
    $this->paypalPlanService = $paypalPlanService;
  }
  public function index(Request $request)
  {
    $this->paypalPlanService->sync();
    // GET THE SLUG, ex. 'posts', 'pages', etc.
    $slug = $this->getSlug($request);
    
    // GET THE DataType based on the slug
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    // Check permission
    $this->authorize('browse', app($dataType->model_name));
    
    $getter = $dataType->server_side ? 'paginate' : 'get';
    
    $checkbox_fields = $dataType->browseRows->where('type', 'checkbox')->pluck('details', 'field')->toArray();
    $value = $request->get('s');
    if(in_array($request->get('key'), array_keys($checkbox_fields))) {
      $params = Helper::arrayIndex($checkbox_fields, $request->get('key'));
      if($params) {
        if(strtolower($value) == strtolower($params->on)) {
          $value = "1";
        }
        if(strtolower($value) == strtolower($params->off)) {
          $value = "0";
        }
      }
    }
    
    $search = (object) ['value' => $value, 'key' => $request->get('key'), 'filter' => $request->get('filter')];
    
    $searchNames = [];
    $searchRelations = collect();
    if ($dataType->server_side) {
      $searchable = $dataType->browseRows->pluck('field')->toArray();
      $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->get();
      foreach ($searchable as $key => $value) {
        $field = $dataRow->where('field', $value)->first();
        $displayName = ucwords(str_replace('_', ' ', $value));
        if ($field !== null) {
          $displayName = $field->getTranslatedAttribute('display_name');
          if($field->type === 'relationship') {
            $searchRelations->push($field);
          }
        }
        $searchNames[$value] = $displayName;
      }
    }
    
    $orderBy = $request->get('order_by', $dataType->order_column);
    $sortOrder = $request->get('sort_order', $dataType->order_direction);
    $usesSoftDeletes = false;
    $showSoftDeleted = false;
    
    // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
    if (strlen($dataType->model_name) != 0) {
      $model = app($dataType->model_name);
      
      if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
        $query = $model->{$dataType->scope}();
      } else {
        $query = $model::select('*');
      }
      
      // Use withTrashed() if model uses SoftDeletes and if toggle is selected
      if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
        $usesSoftDeletes = true;
        
        if ($request->get('showSoftDeleted')) {
          $showSoftDeleted = true;
          $query = $query->withTrashed();
        }
      }
      
      if($model instanceof User) {
        $query->developer(false);
        if($request->segment(2) == 'admins') {
          $query->admins();
        } else if($request->segment(2) == 'customers') {
          abort_if(Gate::denies('view-gx-customers'), 403);
          $query->byMe(request('created_by'))->gxCustomer();
        } else if($request->segment(2) == 'retailers') {
          $query->retailer();
        } else {
          abort_if(Gate::denies('view-hgp-customers'), 403);
          $query->hgpCustomer();
        }
      }
      
      // If a column has a relationship associated with it, we do not want to show that field
      $this->removeRelationshipField($dataType, 'browse');
      
      if ($search->value != '' && $search->key && $search->filter) {
        $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
        $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
        $relationalSearch = $searchRelations->where('field', $search->key)->first();
        if($relationalSearch) {
          if(strpos($search->key, 'belongsto') !== -1) {
            $relationalSearchDetails = (object)$relationalSearch->details;
            if($relationalSearchDetails->table === 'users') {
              $query->whereRaw("{$relationalSearchDetails->column} in (select {$relationalSearchDetails->key} from {$relationalSearchDetails->table} where CONCAT(first_name, ' ', last_name) {$search_filter} ? OR email {$search_filter} ? OR phone_number {$search_filter} ?)", [$search_value, $search_value, $search_value]);
            } else {
              $query->whereRaw("{$relationalSearchDetails->column} in (select {$relationalSearchDetails->key} from {$relationalSearchDetails->table} where {$relationalSearchDetails->label} {$search_filter} ?)", [$search_value]);
            }
          }
          // Further Relations Search if needed
        } else {
          $query->where($search->key, $search_filter, $search_value);
        }
      }
      
      if ($orderBy && in_array($orderBy, $dataType->fields())) {
        $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
        $dataTypeContent = call_user_func([
          $query->orderBy($orderBy, $querySortOrder),
          $getter,
        ]);
      } elseif ($model->timestamps) {
        $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
      } else {
        $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
      }
      
      // Replace relationships' keys for labels and create READ links if a slug is provided.
      $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
    } else {
      // If Model doesn't exist, get data from table name
      $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
      $model = false;
    }
    
    // Check if BREAD is Translatable
    $isModelTranslatable = is_bread_translatable($model);
    
    // Eagerload Relations
    $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);
    
    // Check if server side pagination is enabled
    $isServerSide = isset($dataType->server_side) && $dataType->server_side;
    
    // Check if a default search key is set
    $defaultSearchKey = $dataType->default_search_key ?? null;
    
    // Actions
    $actions = [];
    $instance = get_class($model);
    if (!empty($dataTypeContent->first())) {
      $voyagerActions = array_diff(Voyager::actions(), defined("{$instance}::EXCLUDE_ACTIONS") ? $model::EXCLUDE_ACTIONS : []);
      foreach ($voyagerActions as $action) {
        $action = new $action($dataType, $dataTypeContent->first());
        
        if ($action->shouldActionDisplayOnDataType()) {
          $actions[] = $action;
        }
      }
    }
    
    // Define showCheckboxColumn
    $showCheckboxColumn = false;
    if (Auth::user()->can('delete', app($dataType->model_name))) {
      $showCheckboxColumn = true;
    } else {
      foreach ($actions as $action) {
        if (method_exists($action, 'massAction')) {
          $showCheckboxColumn = true;
        }
      }
    }
    
    if(defined("{$instance}::SHOW_BULK_CHECKBOX")) {
      $showCheckboxColumn = $model::SHOW_BULK_CHECKBOX;
    }
    
    // Define orderColumn
    $orderColumn = [];
    if ($orderBy) {
      $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
      $orderColumn = [[$index, $sortOrder ?? 'desc']];
    }
    
    $view = 'voyager::bread.browse';
    
    if (view()->exists("voyager::$slug.browse")) {
      $view = "voyager::$slug.browse";
    }
    
    if($model instanceof User) {
      if($request->segment(2) == 'admins') {
        $view = "voyager::users.admins";
        $showCheckboxColumn = false;
      }
    }
    
    $search->value = $request->get('s', null);
    return Voyager::view($view, compact(
      'actions',
      'dataType',
      'dataTypeContent',
      'isModelTranslatable',
      'search',
      'orderBy',
      'orderColumn',
      'sortOrder',
      'searchNames',
      'isServerSide',
      'defaultSearchKey',
      'usesSoftDeletes',
      'showSoftDeleted',
      'showCheckboxColumn'
    ));
  }
  public function store(Request $request)
  {
    $slug     = $this->getSlug($request);
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
  
    // Check permission
    $this->authorize('add', app($dataType->model_name));
  
    // Validate fields with ajax
    if (app($dataType->model_name) instanceof User) {
      Helper::checkCreateUserPermissions();
    }
    if (request('source') === 'admins') {
      if (in_array(request('role_id'), Role::adminRoles())) {
        $request->merge(['provider' => 'gx']);
      }
    }
    $val  = $this->validateBread($request->all(), $dataType->addRows)->validate();
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
      $this->createPaypalProduct();
      $this->savePlanToPaypal($data);
      return $redirect->with([
        'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
        'alert-type' => 'success',
      ]);
    } else {
      return response()->json(['success' => true, 'data' => $data]);
    }
  }
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
    if($model instanceof User) {
      $model = $model->byMe();
    }
    if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
      $data = $model->withTrashed()->findOrFail($id);
    } else {
      $data = $model->findOrFail($id);
    }
    $oldPlanAmount = $data->amount;
    $oldPlanState = $data->state;
    
    // Check permission
    $this->authorize('edit', $data);
    
    // Validate fields with ajax
    if($model instanceof User) {
      Helper::checkUpdateUserPermissions();
    }
    $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
    $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
    
    event(new BreadDataUpdated($dataType, $data));
    
    if (auth()->user()->can('browse', app($dataType->model_name))) {
      if(request()->has('source')) {
        $redirect = redirect('/admin/' . request('source'));
      } else {
        $redirect = redirect()->route("voyager.{$dataType->slug}.index");
      }
    } else {
      $redirect = redirect()->back();
    }
    /*update plan amount if amount change*/
    if ($oldPlanAmount != $data->amount){
      $this->updatePaypalPlanPayment($data);
    }
    /*update plan status if change*/
    if ($oldPlanState != $data->state) {
        if ($data->state == Paypal::PLAN_ACTIVE_STATE){
          $this->makePaypalPlanActive($data->plan_id);
        }else {
          $this->makePaypalPlanInactive($data->plan_id);
        }
    }
    
    
    
    return $redirect->with([
      'message'    => __('voyager::generic.successfully_updated')." {$dataType->getTranslatedAttribute('display_name_singular')}",
      'alert-type' => 'success',
    ]);
  }
  private function savePlanToPaypal($data)
  {
    $this->paypalPlanService->setFields($this->prepareCreatePlanReq());
    $this->paypalPlanService->setAPIURL(Paypal::PLAN_API_ENDPOINT);
    $createdPaypalPlan = $this->paypalPlanService->process();
    $this->savePaypalPlanToDB($createdPaypalPlan, $data);
  }
  
  private function createPaypalProduct()
  {
    $productReqBody = [
      "name"        => \request('name', 'grow plan product'),
      "description" => \request('description', 'grow plan product description'),
      "type"        => "SERVICE",
      "category"    => "SOFTWARE",
      "image_url"   => "https://example.com/streaming.jpg",
      "home_url"    => "https://example.com/home"
    ];
    $this->paypalPlanService->setAPIURL(Paypal::PRODUCT_API_ENDPOINT);
    $this->paypalPlanService->setFields($productReqBody);
    $this->paypalPlanService->setHttpReqToType(Paypal::PRODUCT_REQUEST);
    $this->paypalPlanService->process();
  }
  
  private function prepareReqForUpdatePlan()
  {
    $pricing_schemes   = [];
    $pricing_schemes[] = [
      'billing_cycle_sequence'=>1,
      'pricing_scheme' => [
        'fixed_price' => [
          "value"         => \request('amount', 2),
          "currency_code" => $this->paypalPlanService->getCurrency(),
        ]
      ]
    ];
    $reqBody = [
      'pricing_schemes'=>$pricing_schemes
    ];
    return $reqBody;
  }
  
  private function prepareCreatePlanReq()
  {
    $billing_cycles      = [];
    $billing_cycles[]    = [
      'frequency'      => [
        "interval_unit"  => request('frequency', $this->paypalPlanService->defaultFrequency),
        "interval_count" => request('frequency_interval', $this->paypalPlanService->defaultFrequencyInterval),
      ],
      "tenure_type"    => $this->paypalPlanService->paymentDefinitionType,
      "sequence"       => 1,
      "total_cycles"   => 0,
      'pricing_scheme' => [
        'fixed_price' => [
          "value"         => \request('amount', 2),
          "currency_code" => $this->paypalPlanService->getCurrency(),
        ]
      ]
    ];
    $payment_preferences = [
      "auto_bill_outstanding"     => $this->paypalPlanService->autoBilling,
      "setup_fee"                 => [
        "value"         => $this->paypalPlanService->setup_fee,
        "currency_code" => $this->paypalPlanService->getCurrency()
      ],
      "setup_fee_failure_action"  => "CONTINUE",
      "payment_failure_threshold" => 3,
    
    ];
    $requstBody          = [
      'product_id'          => $this->paypalPlanService->getProductId(),
      'name'                => request('name', 'No Plan Name'),
      'description'         => request('description', 'No Plan Description'),
      'billing_cycles'      => $billing_cycles,
      'payment_preferences' => $payment_preferences,
    ];
    
    return ($requstBody);
  }
  
  private function updatePaypalPlanPayment($data)
  {
    $this->paypalPlanService->setFields($this->prepareReqForUpdatePlan());
    $planId = trim($data->plan_id);
    $this->paypalPlanService->setHttpReqToType(Paypal::PLAN_REQUEST);
    $this->paypalPlanService->setAPIURL("billing/plans/{$planId}/update-pricing-schemes");
    $this->paypalPlanService->process();
  }
  
  private function makePaypalPlanActive($planId)
  {
    $this->paypalPlanService->setAPIURL("billing/plans/{$planId}/activate");
    $this->paypalPlanService->process();
  }
  
  private function makePaypalPlanInactive($planId)
  {
    $this->paypalPlanService->setAPIURL("billing/plans/{$planId}/deactivate");
    $this->paypalPlanService->process();
  }
  private function savePaypalPlanToDB($createdPaypalPlan, $data)
  {
    /*change plan status*/
    if ($createdPaypalPlan) {
      $data->plan_id      = $createdPaypalPlan->id;
      $data->created_date = $createdPaypalPlan->create_time;
      $data->product_id   = $createdPaypalPlan->product_id;
      $data->save();
    }
  }
  
}
