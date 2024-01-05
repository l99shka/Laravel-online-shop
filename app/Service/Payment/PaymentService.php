<?php

namespace App\Service\Payment;

use App\Models\Cart;
use App\Models\Order;
use App\Service\Message\MessageService;
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
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;

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
                'order_id' => $options['order_id'],
                'user_id'  => $options['user_id'],
                'email'    => $options['email']
            ]
        ], uniqid('', true)
        );
        return $payment->getConfirmation()->getConfirmationUrl();
    }

    /**
     * @throws NotFoundException
     * @throws ApiException
     * @throws ResponseProcessingException
     * @throws BadApiRequestException
     * @throws ExtensionNotFoundException
     * @throws InternalServerError
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    public function callbackPay(MessageService $message): void
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);
        $notification = ($requestBody['event'] && $requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($requestBody)
            : new NotificationWaitingForCapture($requestBody);
        $payment = $notification->getObject();

        if (isset($payment->status) && $payment->status === 'waiting_for_capture') {
            $this->getClient()->capturePayment([
                'amount' => $payment->amount
            ], $payment->id, uniqid('', true));
        }

        if (isset($payment->status) && $payment->status === 'succeeded') {
            $metadata = $payment->metadata;

            if(isset($metadata->user_id)) {

                $userId = $metadata->user_id;
                Cart::where('user_id', $userId)->delete();
            }
            if ($payment->paid === true) {

                if(isset($metadata->order_id)) {

                    $orderId       = $metadata->order_id;
                    $order         = Order::find($orderId);
                    $order->status = Order::PAID;
                    $order->save();
                }

                if(isset($metadata->email)) {

                    $email = $metadata->email;
                    $queue = 'OrderMessage';
                    $data  = [
                        'email' => $email
                    ];
                    $message->publish($queue, $data);
                }
            }
        }
    }
}
