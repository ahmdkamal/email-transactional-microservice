<?php

namespace App\Providers;

use App\Repositories\EmailRepository;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Services\Interfaces\SendMailInterface;
use App\Services\Interfaces\SendMailServiceInterface;
use App\Services\MailServers\Mailjet;
use App\Services\MailServers\Sendgrid;
use App\Services\SendMail;
use App\Services\SendMailService;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
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
        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
        $this->app->bind(SendMailServiceInterface::class, SendMailService::class);

        $this->app->singleton(SendMailInterface::class, function () {
            return new SendMail(new Sendgrid, [
                new Mailjet,
            ]);
        });
    }
}
