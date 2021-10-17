<?php

namespace App\Listeners;

use App\Events\SendMessageToRoom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageToRoomListener
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
     * @param  SendMessageToRoom  $event
     * @return void
     */
    public function handle(SendMessageToRoom $event)
    {
        //
    }
}
