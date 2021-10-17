<?php

namespace App\Listeners;

use App\Events\SendPrivateBanned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPrivateBannedListener
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
     * @param  SendPrivateBanned  $event
     * @return void
     */
    public function handle(SendPrivateBanned $event)
    {
        //
    }
}
