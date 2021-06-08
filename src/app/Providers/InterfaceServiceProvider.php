<?php

namespace App\Providers;

use App\Services\Interfaces\InterfaceSendMailService;
use App\Services\Interfaces\InterfaceSendMessage;
use App\Services\SendMailService;
use App\Services\SendMessage;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(InterfaceSendMessage::class, SendMessage::class);
        $this->app->bind(InterfaceSendMailService::class, SendMailService::class);
    }
}
