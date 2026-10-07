<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'starts_at',
        'expires_at',
        'usage_limit',
        'active',
    ];

    public function carts():HasMany{
        return $this->hasMany(Cart::class);
    }

    public function sales():HasMany{
        return $this->hasMany(Sale::class);
    }
}
