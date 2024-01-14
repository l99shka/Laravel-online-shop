<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use AuthenticableTrait;

    protected $fillable = [
        'user_id',
        'comment',
        'contact_phone',
        'email',
        'status'
    ];

    public const PAID = 'PAID';
    public const CANCELED = 'CANCELED';
    public const UNPAID = 'UNPAID';

    public static function getPaidOrdersCountLastMonth()
    {
        return self::where('status', 'PAID')->whereBetween('created_at', [now()->subMonth(), now()])->count();
    }
}
