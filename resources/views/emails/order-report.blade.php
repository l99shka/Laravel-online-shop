@component('mail::message')
    # Ежемесячный отчет о заказах - {{ $month }}

    Всего заказао со статусом "ОПЛАЧЕНО": {{ $ordersCount }}, на сумму: {{ $sumTotalPricePaid }}

    Спасибо, <br>
    {{ config('app.name') }}
@endcomponent
