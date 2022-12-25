<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\MessageAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function sendMessage(Request $request) {

//        $validator = Validator::make($request->all(), [
//            'message' => 'required'
//        ]);
//
//        if ($validator->fails())
//        {
//            return errorResponse(__('message is required'), $validator->errors()->all());
//        }

        try {

            if(is_null($request->chat_id)) {
                $chat = new Chat();
                $chat->assigned_to = auth()->user()->assigned_to;
                $chat->chat_with = auth()->id();
                $chat->last_message = $request->message;
                $chat->save();
            } else {
                $chat = Chat::find($request->chat_id);
                if(is_null($chat->assigned_to)) {
                    $chat->assigned_to = auth()->user()->assigned_to;
                    $chat->save();
                    Message::whereSender(auth()->id())->update([
                        'receiver' => auth()->user()->assigned_to
                    ]);
                }
            }

            $message = new Message();
            $message->message = $request->message;
            $message->sender = \Auth::id();
            $message->receiver = $chat->assigned_to;
            $message->chat_id = $chat->id;
            $message->save();

            $chat->last_message = $request->message;
            $chat->save();

            if($request->has('files')) {
                MessageAttachment::uploadAttachments($request, $message->id);
            }

            return successResponse(__('Message Sent'), Message::myMessages());

        } catch (\Exception $exception) {
            return errorResponse(__('generic.error'), $exception->getMessage());
        }
    }

    public function getAll() {
//        $data['chat'] = Chat::userChat();
//        $data['messages'] = Message::myMessages();
        return successResponse(__('All My Messages'), Message::myMessages());
    }
}
