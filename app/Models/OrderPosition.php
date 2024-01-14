<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPosition extends Model
{
    use HasFactory;
    use AuthenticableTrait;

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function getTotalPriceOfPaidOrders()
    {
        return self::whereHas('order', function ($query) {
            $query->where('status', 'PAID');
        })->sum('total_price');
    }
}
