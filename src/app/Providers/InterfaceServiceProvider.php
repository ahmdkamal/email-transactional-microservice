<?php

namespace App\Providers;

use App\Repositories\EmailRepository;
use App\Repositories\Interfaces\InterfaceEmailRepository;
use App\Services\Interfaces\InterfaceSendMail;
use App\Services\Interfaces\InterfaceSendMailService;
use App\Services\MailServers\Mailjet;
use App\Services\MailServers\Sendgrid;
use App\Services\SendMail;
use App\Services\SendMailService;
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
        $this->app->bind(InterfaceEmailRepository::class, EmailRepository::class);
        $this->app->bind(InterfaceSendMailService::class, SendMailService::class);

        $this->app->singleton(InterfaceSendMail::class, function () {
            return new SendMail(new Sendgrid, [new Mailjet]);
        });
    }
}
