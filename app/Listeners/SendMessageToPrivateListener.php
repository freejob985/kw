<?php

namespace App\Listeners;

use App\Events\SendMessageToPrivate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageToPrivateListener
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
     * @param  SendMessageToPrivate  $event
     * @return void
     */
    public function handle(SendMessageToPrivate $event)
    {
        //
    }
}
