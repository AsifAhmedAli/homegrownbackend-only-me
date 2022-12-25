<?php

namespace App\Http\Controllers\Voyager;

use App\Gx\GrowLog;
use App\Gx\GrowLogDetail;
use App\Gx\GrowLogFeedback;
use App\Gx\Ticket;
use App\Gx\TicketMessage;
use App\Models\UserKit;
use App\Models\UserSubscription;
use App\Role;
use App\User;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use Gate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Http\Controllers\ContentTypes\Checkbox;
use TCG\Voyager\Http\Controllers\ContentTypes\Coordinates;
use TCG\Voyager\Http\Controllers\ContentTypes\File;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Http\Controllers\ContentTypes\MultipleCheckbox;
use TCG\Voyager\Http\Controllers\ContentTypes\MultipleImage;
use TCG\Voyager\Http\Controllers\ContentTypes\Password;
use TCG\Voyager\Http\Controllers\ContentTypes\Relationship;
use TCG\Voyager\Http\Controllers\ContentTypes\SelectMultiple;
use TCG\Voyager\Http\Controllers\ContentTypes\Text;
use TCG\Voyager\Http\Controllers\ContentTypes\Timestamp;
use Validator;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use Voyager;

class VoyagerController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{
    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $checkbox_fields = $dataType->browseRows->where('type', 'checkbox')->pluck('details', 'field')->toArray();
        $value = $request->get('s');
        if (in_array($request->get('key'), array_keys($checkbox_fields))) {
            $params = Helper::arrayIndex($checkbox_fields, $request->get('key'));
            if ($params) {
                if (strtolower($value) == strtolower($params->on)) {
                    $value = "1";
                }
                if (strtolower($value) == strtolower($params->off)) {
                    $value = "0";
                }
            }
        }

        $search = (object)['value' => $value, 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        $searchRelations = collect();
        if ($dataType->server_side) {
            $searchable = $dataType->browseRows->pluck('field')->toArray();
            $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->get();
            foreach ($searchable as $key => $value) {
                $field = $dataRow->where('field', $value)->first();
                if (Helper::showFieldByRole($field)) {
                    $displayName = ucwords(str_replace('_', ' ', $value));
                    if ($field !== null) {
                        $displayName = $field->getTranslatedAttribute('display_name');
                        if ($field->type === 'relationship') {
                            $searchRelations->push($field);
                        }
                    }
                    $searchNames[$value] = $displayName;
                }
            }
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
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

            if ($model instanceof User) {
                $query->developer(false);
                if ($request->segment(2) == 'admins') {
                    $query->admins();
                } else if ($request->segment(2) == 'customers') {
                    abort_if(Gate::denies('view-gx-customers'), 403);
                    $query->byMe(request('created_by'))->gxCustomer();
                } else if ($request->segment(2) == 'retailers') {
                    $query->retailer();
                } else {
                    abort_if(Gate::denies('view-hgp-customers'), 403);
                    $query->hgpCustomer();
                }
            }

            if ($model instanceof UserKit || $model instanceof Ticket || $model instanceof UserSubscription || $model instanceof GrowLog) {
                $query->when(request('user_id'), function ($q) {
                    $q->whereUserId(request('user_id'));
                })->myCustomerData('all');
            }

            if ($model instanceof GrowLogDetail) {
                if (isset($request->log_id)) {
                    $query->where("log_id", $request->log_id)->myCustomerData();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
                $relationalSearch = $searchRelations->where('field', $search->key)->first();
                if ($relationalSearch) {
                    if (strpos($search->key, 'belongsto') !== -1) {
                        $relationalSearchDetails = (object)$relationalSearch->details;
                        if ($relationalSearchDetails->table === 'users') {
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

        if (defined("{$instance}::SHOW_BULK_CHECKBOX")) {
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

        if ($model instanceof User) {
            if ($request->segment(2) == 'admins') {
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

    /**
     * Get fields having validation rules in proper format.
     *
     * @param array $fieldsConfig
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getFieldsWithValidationRules($fieldsConfig)
    {
        return $fieldsConfig->filter(function ($value) {
            if (empty($value->details)) {
                return false;
            }

            if (!Helper::empty(optional($value->details)->user)) {
                return Helper::allowedFieldByUser($value);
            }

            return !empty($value->details->validation->rule) || !empty($value->details->validation->add) || !empty($value->details->validation->edit);
        });
    }

    /**
     * Validates bread POST request.
     *
     * @param array $data The data
     * @param array $rows The rows
     * @param string $slug Slug
     * @param int $id Id of the record to update
     *
     * @return mixed
     */
    public function validateBread($data, $rows, $name = null, $id = null)
    {
        $rules = [];
        $messages = [];
        $customAttributes = [];
        $is_update = $name && $id;

        $fieldsWithValidationRules = $this->getFieldsWithValidationRules($rows);
        foreach ($fieldsWithValidationRules as $field) {
            $fieldRules = optional($field->details->validation)->rule ?: [];
            $fieldName = $field->field;

            // Show the field's display name on the error message
            if (!empty($field->display_name)) {
                if (!empty($data[$fieldName]) && is_array($data[$fieldName])) {
                    foreach ($data[$fieldName] as $index => $element) {
                        if ($element instanceof UploadedFile) {
                            $name = $element->getClientOriginalName();
                        } else {
                            $name = $index + 1;
                        }

                        $customAttributes[$fieldName . '.' . $index] = $field->getTranslatedAttribute('display_name') . ' ' . $name;
                    }
                } else {
                    $customAttributes[$fieldName] = $field->getTranslatedAttribute('display_name');
                }
            }

            // If field is an array apply rules to all array elements
            $fieldName = !empty($data[$fieldName]) && is_array($data[$fieldName]) ? $fieldName . '.*' : $fieldName;

            // Get the rules for the current field whatever the format it is in
            $rules[$fieldName] = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            if ($id && property_exists($field->details->validation, 'edit')) {
                $action_rules = $field->details->validation->edit->rule;
                $rules[$fieldName] = array_merge($rules[$fieldName], (is_array($action_rules) ? $action_rules : explode('|', $action_rules)));
            } elseif (!$id && property_exists($field->details->validation, 'add')) {
                $action_rules = $field->details->validation->add->rule;
                $rules[$fieldName] = array_merge($rules[$fieldName], (is_array($action_rules) ? $action_rules : explode('|', $action_rules)));
            }
            // Fix Unique validation rule on Edit Mode
            if ($is_update) {
                foreach ($rules[$fieldName] as &$fieldRule) {
                    if (strpos(strtoupper($fieldRule), 'UNIQUE') !== false) {
                        $fieldRule = \Illuminate\Validation\Rule::unique($name)->ignore($id);
                    }
                    if (strpos(strtoupper($fieldRule), strtoupper('distinct_provider')) !== false) {
                        $fieldRule .= ",id,{$id}";
                    }
                }
            }

            // Set custom validation messages if any
            if (!empty($field->details->validation->messages)) {
                foreach ($field->details->validation->messages as $key => $msg) {
                    $messages["{$field->field}.{$key}"] = $msg;
                }
            }
        }

        return Validator::make($data, $rules, $messages, $customAttributes);
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            if ($model instanceof User) {
                $model = $model->byMe();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);
        if ($dataTypeContent instanceof User) {
            Helper::checkUpdateUserPermissions();
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    public function update(Request $request, $id)
    {

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model instanceof User) {
            $model = $model->byMe();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = $model->findOrFail($id);
        }

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        if ($model instanceof User) {
            Helper::checkUpdateUserPermissions();
        }
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            if (request()->has('source')) {
                $redirect = redirect('/admin/' . request('source'));
            } else {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            }
        } else {
            $redirect = redirect()->back();
        }

        if (app($dataType->model_name) instanceof GrowLogFeedback) {
            $redirect = redirect('/admin/view/grow-log-feedback?grow_log_detail_id=' . $data->grow_log_detail_id);

        }

        return $redirect->with([
            'message' => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();


        if (app($dataType->model_name) instanceof TicketMessage) {
            $ticket = Ticket::myCustomerData()->find(request('ticket'));
            abort_if(is_null($ticket), 403);
        }

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        if (app($dataType->model_name) instanceof User) {
            Helper::checkCreateUserPermissions();
        }
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'add', $isModelTranslatable);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);
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
        if (app($dataType->model_name) instanceof TicketMessage) {
            $request->merge(['user_id' => auth()->id()]);
            // Verify
            $ticket = Ticket::myCustomerData()->find(request('ticket_id'));
            abort_if(is_null($ticket), 403);
        }
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        if (app($dataType->model_name) instanceof TicketMessage) {
//        if (strtolower($ticket->status) === Constant::CLOSED || strtolower($ticket->status) === Constant::ON_HOLD) {
            $ticket->status = Constant::IN_PROGRESS;
            $ticket->save();
//        }
            Helper::sendTicketReplyEmail($ticket, $data);
        }

        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                if (request()->has('source')) {
                    $redirect = redirect('/admin/' . request('source'));
                } else {
                    $redirect = redirect()->route("voyager.{$dataType->slug}.index");
                }
            } else {
                $redirect = redirect()->back();
            }
            if (app($dataType->model_name) instanceof TicketMessage) {
                $redirect = redirect()->back();
            }

            if (app($dataType->model_name) instanceof GrowLogFeedback) {
                $redirect = redirect('/admin/view/grow-log-feedback?grow_log_detail_id=' . $request->grow_log_detail_id);
            }

            return $redirect->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

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
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            if ($model instanceof User) {
                $model = $model->byMe();
            }
            if ($model instanceof UserKit || $model instanceof Ticket || $model instanceof GrowLog || $model instanceof UserSubscription) {
                $model = $model->myCustomerData();
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
        if ($dataTypeContent instanceof User) {
            Helper::checkReadUserPermissions();
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'read', $isModelTranslatable);

        $view = 'voyager::bread.read';

        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        if($request->has('status')){

            $response = $dataTypeContent->changeStatus($request->status);
            if(!$response) {
                return redirect()->back()->with([
                    'alert-type' => 'error',
                    'message' => __('generic.status_unchanged')
                ]);
            }

            return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted'))
                ->with([
                    'alert-type' => 'success',
                    'message' => __('generic.status_changed')
                ]);

        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted'));
    }

    public function destroy(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Init array of IDs
        $ids = [];
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL
            $ids[] = $id;
        }
        foreach ($ids as $id) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

            // Check permission
            $this->authorize('delete', $data);

            $model = app($dataType->model_name);
            if (!($model && in_array(SoftDeletes::class, class_uses_recursive($model)))) {
                $this->cleanup($dataType, $data);
            }
        }

        $displayName = count($ids) > 1 ? $dataType->getTranslatedAttribute('display_name_plural') : $dataType->getTranslatedAttribute('display_name_singular');

        $source = null;
        if ($model instanceof User) {
            $source = 'admins';
            $deletedRoles = User::whereIn('id', $ids)->pluck('role_id')->toArray();
            $role = Helper::arrayIndex($deletedRoles, 0, 3);
            $deletedProvider = User::whereIn('id', $ids)->pluck('provider')->toArray();
            $provider = Helper::arrayIndex($deletedProvider, 0, Constant::HGP);

            if ($role === Role::RETAILER_ROLE) {
                $source = 'retailers';
            } elseif ($role === Role::NORMAL_USER_ROLE) {
                $source = 'users';
                if ($provider === Constant::GX) {
                    $source = 'customers';
                }
            }
        }

        $res = $data->destroy($ids);
        $data = $res
            ? [
                'message' => __('voyager::generic.successfully_deleted') . " {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message' => __('voyager::generic.error_deleting') . " {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        if ($source) {
            return redirect('/admin/' . $source)->with($data);
        } else {
            return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
        }
    }

    public function insertUpdateData($request, $slug, $rows, $data)
    {
        $multi_select = [];

        // Pass $rows so that we avoid checking unused fields
        $request->attributes->add(['breadRows' => $rows->pluck('field')->toArray()]);

        /*
         * Prepare Translations and Transform data
         */
        $translations = is_bread_translatable($data)
            ? $data->prepareTranslations($request)
            : [];

        foreach ($rows as $row) {
            // if the field for this row is absent from the request, continue
            // checkboxes will be absent when unchecked, thus they are the exception
            if (!$request->hasFile($row->field) && !$request->has($row->field) && $row->type !== 'checkbox') {
                // if the field is a belongsToMany relationship, don't remove it
                // if no content is provided, that means the relationships need to be removed
                if (isset($row->details->type) && $row->details->type !== 'belongsToMany') {
                    continue;
                }
            }

            // Value is saved from $row->details->column row
            if ($row->type == 'relationship' && $row->details->type == 'belongsTo') {
                continue;
            }

            $content = $this->getContentBasedOnType($request, $slug, $row, $row->details);


            if ($row->type == 'relationship' && $row->details->type != 'belongsToMany') {
                $row->field = @$row->details->column;
            }

            /*
             * merge ex_images/files and upload images/files
             */
            if (in_array($row->type, ['multiple_images', 'file', 'video']) && !is_null($content)) {

                if (isset($data->{$row->field})) {
                    $ex_files = json_decode($data->{$row->field}, true);
                    if (!is_null($ex_files)) {
                        $content = json_encode(array_merge($ex_files, json_decode($content)));
                    }
                }
            }

            if (is_null($content)) {

                // If the image upload is null and it has a current image keep the current image
                if ($row->type == 'image' && is_null($request->input($row->field)) && isset($data->{$row->field})) {
                    $content = $data->{$row->field};
                }

                // If the multiple_images upload is null and it has a current image keep the current image
                if ($row->type == 'multiple_images' && is_null($request->input($row->field)) && isset($data->{$row->field})) {
                    $content = $data->{$row->field};
                }

                // If the file upload is null and it has a current file keep the current file
                if ($row->type == 'file') {
                    $content = $data->{$row->field};
                    if (!$content) {
                        $content = json_encode([]);
                    }
                }

                if ($row->type == 'password') {
                    $content = $data->{$row->field};
                }
            }

            if ($row->type == 'relationship' && $row->details->type == 'belongsToMany') {
                // Only if select_multiple is working with a relationship
                $multi_select[] = [
                    'model' => $row->details->model,
                    'content' => $content,
                    'table' => $row->details->pivot_table,
                    'foreignPivotKey' => $row->details->foreign_pivot_key ?? null,
                    'relatedPivotKey' => $row->details->related_pivot_key ?? null,
                    'parentKey' => $row->details->parent_key ?? null,
                    'relatedKey' => $row->details->key,
                ];
            } else {
                $data->{$row->field} = $content;
            }
        }

        if (isset($data->additional_attributes)) {
            foreach ($data->additional_attributes as $attr) {
                if ($request->has($attr)) {
                    $data->{$attr} = $request->{$attr};
                }
            }
        }

        $data->save();

        // Save translations
        if (count($translations) > 0) {
            $data->saveTranslations($translations);
        }

        foreach ($multi_select as $sync_data) {
            $data->belongsToMany(
                $sync_data['model'],
                $sync_data['table'],
                $sync_data['foreignPivotKey'],
                $sync_data['relatedPivotKey'],
                $sync_data['parentKey'],
                $sync_data['relatedKey']
            )->sync($sync_data['content']);
        }

        // Rename folders for newly created data through media-picker
        if ($request->session()->has($slug . '_path') || $request->session()->has($slug . '_uuid')) {
            $old_path = $request->session()->get($slug . '_path');
            $uuid = $request->session()->get($slug . '_uuid');
            $new_path = str_replace($uuid, $data->getKey(), $old_path);
            $folder_path = substr($old_path, 0, strpos($old_path, $uuid)) . $uuid;

            $rows->where('type', 'media_picker')->each(function ($row) use ($data, $uuid) {
                $data->{$row->field} = str_replace($uuid, $data->getKey(), $data->{$row->field});
            });
            $data->save();
            if ($old_path != $new_path && !Storage::disk(config('voyager.storage.disk'))->exists($new_path)) {
                $request->session()->forget([$slug . '_path', $slug . '_uuid']);
                Storage::disk(config('voyager.storage.disk'))->move($old_path, $new_path);
                Storage::disk(config('voyager.storage.disk'))->deleteDirectory($folder_path);
            }
        }

        return $data;
    }

    public function getContentBasedOnType(Request $request, $slug, $row, $options = null)
    {
        switch ($row->type) {
            /********** PASSWORD TYPE **********/
            case 'password':
                return (new Password($request, $slug, $row, $options))->handle();
            /********** CHECKBOX TYPE **********/
            case 'checkbox':
                return (new Checkbox($request, $slug, $row, $options))->handle();
            /********** MULTIPLE CHECKBOX TYPE **********/
            case 'multiple_checkbox':
                return (new MultipleCheckbox($request, $slug, $row, $options))->handle();
            /********** FILE TYPE **********/
            case 'file':
            case 'video':
                return (new MyFile($request, $slug, $row, $options))->handle();
            /********** MULTIPLE IMAGES TYPE **********/
            case 'multiple_images':
                return (new MultipleImage($request, $slug, $row, $options))->handle();
            /********** SELECT MULTIPLE TYPE **********/
            case 'select_multiple':
                return (new SelectMultiple($request, $slug, $row, $options))->handle();
            /********** IMAGE TYPE **********/
            case 'image':
                return (new ContentImage($request, $slug, $row, $options))->handle();
            /********** DATE TYPE **********/
            case 'date':
                /********** TIMESTAMP TYPE **********/
            case 'timestamp':
                return (new Timestamp($request, $slug, $row, $options))->handle();
            /********** COORDINATES TYPE **********/
            case 'coordinates':
                return (new Coordinates($request, $slug, $row, $options))->handle();
            /********** RELATIONSHIPS TYPE **********/
            case 'relationship':
                return (new Relationship($request, $slug, $row, $options))->handle();
            /********** ALL OTHER TEXT TYPE **********/
            default:
                return (new Text($request, $slug, $row, $options))->handle();
        }
    }
}
