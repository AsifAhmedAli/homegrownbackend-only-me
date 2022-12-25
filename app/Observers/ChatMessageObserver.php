<?php

namespace App\Observers;

use App\Models\ChatNotification;
use App\Models\Message;
use App\Services\SocketIoService;

class ChatMessageObserver
{
    /**
     * Handle the message "created" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        ChatNotification::create([
           'notification' => '<a href="/admin/chats/' .$message->chat_id  .'">You have a new message from '. $message->senderUser->first_name . '</a>',
           'notification_to'    => $message->receiver,
        ]);
    }

    /**
     * Handle the message "updated" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function updated(Message $message)
    {
        //
    }

    /**
     * Handle the message "deleted" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        //
    }

    /**
     * Handle the message "restored" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function restored(Message $message)
    {
        //
    }

    public function retrieved(Message $message)
    {
        if ($message->receiver == auth()->id()) {
            $message->seen = 1;
            $message->save();

            ChatNotification::whereNotificationTo(auth()->id())->update([
                'seen' => 1
            ]);
        }
    }

    /**
     * Handle the message "force deleted" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
    }
}
