<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatNotification;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Role;
use App\Services\SocketIoService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class VoyagerChatController extends VoyagerBaseController
{
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
        if (!in_array(auth()->user()->role_id, Role::adminRoles()) && !Chat::whereAssignedTo(auth()->id())->exists()) {
            abort(403);
        }
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

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted'));
    }

    public function sendMessage($chatID, Request $request)
    {
        /*$validator = Validator::make($request->all(), [
           'message' => 'required'
        ]);

        if ($validator->fails())
        {
            return errorResponse(__('message is required'), $validator->errors()->all());
        }*/

        try {

            $chat = Chat::find($chatID);
            $message = new Message();
            $message->message = $request->message ?? NULL;
            $message->sender = \Auth::id();
            $message->receiver = $chat->chat_with;
            $message->chat_id = $chatID;
            $message->save();

            $chat->last_message = $request->message;
            $chat->save();

            if($request->has('files')) {
                MessageAttachment::uploadAttachments($request, $message->id);
            }

            $data['messages'] = Message::whereChatId($chatID)->get();
            $data['room']   = 'room-' . $chatID;
            $data['sender'] = auth()->id();
           // SocketIoService::emit($messages);

            return successResponse(__('Message Sent'), $data);
           // return view('voyager::chats.messages', compact('messages'))->render();

        } catch (\Exception $exception) {
            return errorResponse(__('generic.error'), $exception->getMessage());
        }
    }

    public function all($chatID) {
        $messages = Message::whereChatId($chatID)->get();
        return view('voyager::chats.messages', compact('messages'))->render();
    }

    public function readMessage($chatID) {
        Message::whereChatId($chatID)->whereReceiver(\Auth::id())->update([
           'seen' => 1
        ]);

        ChatNotification::whereNotificationTo(auth()->id())->update([
            'seen' => 1
        ]);
    }


    public function getNotifications() {
        $notifications = ChatNotification::new();
        $view = view('vendor.voyager.chats.notifications', ['notifications' => $notifications])->render();
        return response()->json(['view' => $view, 'count' => count($notifications)]);
    }
}
