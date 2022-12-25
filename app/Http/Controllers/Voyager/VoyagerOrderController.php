<?php

namespace App\Http\Controllers\Voyager;

use App\Gx\GrowLog;
use App\Gx\Ticket;
use App\Http\Controllers\Controller;
use App\Models\UserKit;
use App\Models\UserSubscription;
use App\OrderProduct;
use App\User;
use App\Utils\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class VoyagerOrderController extends VoyagerController
{
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


        $hasKits = OrderProduct::whereOrderId($dataTypeContent->id)->count('kit_id');

        $redirection = Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted', 'hasKits'));

        if($request->has('kit_status')){
            $response = $dataTypeContent->changeStatus($request->kit_status);
            if(!$response) {
                $redirection = redirect()->back()->with([
                    'alert-type' => 'error',
                    'message' => __('generic.status_unchanged')
                ]);
            } else {
                $redirection = redirect()->back()->with([
                    'alert-type' => 'success',
                    'message' => __('generic.status_changed')
                ]);
            }
        }

        if($request->has('kit_tracking_number')) {
            $response = $dataTypeContent->changeTrackingNumber($request->kit_tracking_number);
            if($response) {
                $redirection = redirect()->back()->with([
                    'alert-type' => 'success',
                    'message' => __('generic.tracking_number_changed')
                ]);
            }

            return $redirection;
        }


        return $redirection;

    }

}
