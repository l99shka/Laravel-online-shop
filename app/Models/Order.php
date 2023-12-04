<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use AuthenticableTrait;
    protected $guarded = [];

    public const PAID = 'PAID';
    public const CANCELED = 'CANCELED';
    public const UNPAID = 'UNPAID';
}
