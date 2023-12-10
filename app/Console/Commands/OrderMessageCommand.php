<?php

namespace App\Console\Commands;

use App\Mail\OrderMessageMail;
use App\Service\MessageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class OrderMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:order-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $messageService = new MessageService();
        $messageService->consume('OrderMessage', function ($body) {
            $email = json_decode($body)->email;
            Mail::to($email)->send(new OrderMessageMail());
        });
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
    }
}
