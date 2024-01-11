<?php

namespace App\Providers;

use App\Service\Message\MessageService;
use App\Service\Payment\PaymentService;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use YooKassa\Client;

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
            $client = $app->make(Client::class);
            return new PaymentService($client);
        });

        $this->app->bind(MessageService::class, function ($app) {
            return new MessageService();
        });

        $this->app->bind(Client::class, function ($app) {
            $client = new Client();
            $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));

            return $client;
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
