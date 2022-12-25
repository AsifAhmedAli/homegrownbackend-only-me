<?php

namespace App\Listeners;

use App\Events\ChangeKitTrackingNumber;
use App\Mail\TrackingKitMail;
use App\Models\UserKit;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackingKitListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Models\UserKit  $userKit
     * @return void
     */
    public function handle(ChangeKitTrackingNumber $event)
    {
        // Access the order using $event->order...
        \Mail::to($event->order->user->email)->send(new TrackingKitMail($event->order));
    }
}
