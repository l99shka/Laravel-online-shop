<?php

namespace App\Providers;

use App\Service\MessageService;
use App\Service\PaymentService;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentService::class, function ($app) {
            return new PaymentService();
        });

        $this->app->bind(MessageService::class, function ($app) {
            return new MessageService();
        });

        $this->app->bind(MessageService::class, function ($app) {
            return new MessageService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Подтверждение E-mail')
                ->line('Нажмите для подтверждения')
                ->action('Подтвердить', $url);
        });
    }
}
