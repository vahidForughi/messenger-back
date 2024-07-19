<?php

namespace Modules\messenger\app\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes([
            'middleware' => [
                \Modules\messenger\app\Http\Middleware\QueryStringMiddleware::class,
                'auth:sanctum']
        ]);

        require base_path('modules/messenger/routes/channels.php');
    }
}
