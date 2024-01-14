<?php

namespace App\Console\Commands;

use App\Mail\OrderReport;
use App\Models\Order;
use App\Models\OrderPosition;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendOrderReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать и отравить отчет о количестве оплаченных заказов за последний месяц';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ordersCount = Order::getPaidOrdersCountLastMonth();
        $sumTotalPricePaid = OrderPosition::getTotalPriceOfPaidOrders();
        $data = [
            'month'             => now()->subMonth()->format('F Y'),
            'ordersCount'       => $ordersCount,
            'sumTotalPricePaid' => $sumTotalPricePaid
        ];

        Mail::to('l99shka@icloud.com')->send(new OrderReport($data));

        $this->info('Отчет о количетсве оплаченных заказах за последний месяц отправлен');
    }
}
