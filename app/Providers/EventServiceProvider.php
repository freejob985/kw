<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
     protected $listen = [
        'App\Events\SendMessageToRoom' => [
            'App\Listeners\SendMessageToRoomListener',
        ],
          'App\Events\SendMessageToPrivate' => [
            'App\Listeners\SendMessageToPrivateListener',
        ],
          'App\Events\SendPrivateNotifications' => [
            'App\Listeners\SendPrivateNotificationsListener',
        ],
          'App\Events\SendPrivateBanned' => [
            'App\Listeners\SendPrivateBannedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
