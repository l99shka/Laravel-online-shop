<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiConnectionException;
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Common\Exceptions\AuthorizeException;
use YooKassa\Common\Exceptions\BadApiRequestException;
use YooKassa\Common\Exceptions\ExtensionNotFoundException;
use YooKassa\Common\Exceptions\ForbiddenException;
use YooKassa\Common\Exceptions\InternalServerError;
use YooKassa\Common\Exceptions\NotFoundException;
use YooKassa\Common\Exceptions\ResponseProcessingException;
use YooKassa\Common\Exceptions\TooManyRequestsException;
use YooKassa\Common\Exceptions\UnauthorizedException;

class PaymentService
{
    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));

        return $client;
    }

    /**
     * @param float $amount
     * @return string
     * @throws ApiConnectionException
     * @throws ApiException
     * @throws AuthorizeException
     * @throws BadApiRequestException
     * @throws ExtensionNotFoundException
     * @throws ForbiddenException
     * @throws InternalServerError
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    public function createPayment(float $amount, array $options = [])
    {
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value'    => $amount,
                'currency' => 'RUB'
            ],
            'confirmation' => [
                'type'       => 'redirect',
                'return_url' => route('main')
            ],
            'capture' => false,
            'metadata' => [
                'order_id'       => $options['order_id'],
                'user_id'        => $options['user_id'],
                'email'          => $options['email']
            ]
        ], uniqid('', true)
        );
        return $payment->getConfirmation()->getConfirmationUrl();
    }
}
