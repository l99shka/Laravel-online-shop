<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessageService
{
    protected AMQPStreamConnection $connection;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD')
        );

    }
    public function publish(string $queue, array $data)
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queue, false, true, false, false);
        $jsonMessage = json_encode($data);
        $msg = new AMQPMessage($jsonMessage);
        $channel->basic_publish($msg, '', $queue);

        $channel->close();
        $this->connection->close();
    }

    public function consume(string $queue, callable $callback)
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queue, false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $channel->basic_consume($queue, '', false, true, false, false,
            function ($msg) use ($callback) {
                call_user_func($callback, $msg->body);
        });

        while (count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $this->connection->close();
    }
}
