<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPosition extends Model
{
    use HasFactory;
    use AuthenticableTrait;
    protected $guarded = [];
}
