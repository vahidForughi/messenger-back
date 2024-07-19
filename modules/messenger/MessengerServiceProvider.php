<?php

namespace Modules\messenger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Modules\messenger\app\Providers\BroadcastServiceProvider;
use Modules\messenger\app\Providers\RouteServiceProvider;
use Modules\messenger\app\Providers\ServiceServiceProvider;

class MessengerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(ServiceServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BroadcastServiceProvider::class);

        Response::macro('messengerJsonSuccess', function ($data, $status = 200) {
            return Response::json([
                'success' => true,
                'status' => $status,
                'data' => $data,
            ]);
        });

        Response::macro('messengerJsonError', function ($error, $status = 400, $message = null, $trace = null) {
            return Response::json([
                'success' => false,
                'status' => $status,
                'error' => $error,
                'message' => $message,
                'trace' => $trace,
            ]);
        });
    }
}
