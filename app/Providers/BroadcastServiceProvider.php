<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         if(request()->hasHeader('authorization')) {
            Broadcast::routes(["middleware" => "auth:api"]); 
            $user = auth()->guard('api')->user();
            request()->setUserResolver(function () use ($user) {
                return $user;
            });
        } else {
            Broadcast::routes();
        }

        require base_path('routes/channels.php');
    }
}
