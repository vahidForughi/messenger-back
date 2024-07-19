<?php

namespace Modules\messenger\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\messenger\app\Services\MessengerFavorite\MessengerFavoriteService;
use Modules\messenger\app\Services\MessengerFile\MessengerFileService;
use Modules\messenger\app\Services\MessengerUser\MessengerUserService;
use Modules\messenger\app\Services\MessengerUserMessage\MessengerUserMessageService;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->app->singleton(MessengerUserService::class, MessengerUserService::class);

        $this->app->singleton(MessengerFavoriteService::class, MessengerFavoriteService::class);

        $this->app->singleton(MessengerUserMessageService::class, MessengerUserMessageService::class);

        $this->app->singleton(MessengerFileService::class, MessengerFileService::class);

    }

}
