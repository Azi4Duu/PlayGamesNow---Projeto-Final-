<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'subtotal',
        'discount',
        'total',
        'status',
        'payment_method',
        'payment_reference',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function coupon():BelongsTo{
        return $this->belongsTo(Coupon::class);
    }

    public function items():HasMany{
        return $this->hasMany(SaleItem::class);
    }
}
