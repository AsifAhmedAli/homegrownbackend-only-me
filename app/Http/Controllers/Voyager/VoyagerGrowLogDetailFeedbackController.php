<?php

namespace App\Http\Controllers\Voyager;

use App\Gx\GrowLogDetail;
use App\Gx\GrowLogFeedback;
use Illuminate\Http\Request;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;

class VoyagerGrowLogDetailFeedbackController extends VoyagerController
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
                if(Helper::showFieldByRole($field)) {
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

            if($model instanceof GrowLogFeedback) {
                $query->where("grow_log_detail_id",$request->grow_log_detail_id);
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

}
