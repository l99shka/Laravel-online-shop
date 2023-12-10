<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Service\MessageService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;

class MailConfirmationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:mail-confirmation';

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
        $messageService->consume('Registration', function ($body) {
            $id = json_decode($body)->id;
            $user = User::find($id);
            event(new Registered($user));
        });
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
    }
}
