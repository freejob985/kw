<?php

namespace App\Listeners;

use App\Events\SendPrivateNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPrivateNotificationsListener
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
     * @param  SendPrivateNotifications  $event
     * @return void
     */
    public function handle(SendPrivateNotifications $event)
    {
        //
    }
}
