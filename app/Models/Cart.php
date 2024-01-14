<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'user_id')->withTimestamps();
    }

    public static function getTotalSumQty()
    {
        $cart = self::where('user_id', Auth::id())->first();

        if ($cart) {
            return $cart->products->where('pivot.user_id', Auth::id())->sum('pivot.quantity');
        }
        return 0;
    }
}
