<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'game_platform_id',
        'quantity',
    ];

    public function cart():BelongsTo{
        return $this->belongsTo(Cart::class);
    }

    public function gamePlatform():BelongsTo{
        return $this->belongsTo(GamePlatform::class);
    }
}
