<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'game_platform_id',
        'quantity',
        'unit_price',
    ];

    public function sale():BelongsTo{
        return $this->belongsTo(Sale::class);
    }

    public function gamePlatform():BelongsTo{
        return $this->belongsTo(GamePlatform::class);
    }

    public function saleKeys():HasMany{
        return $this->hasMany(SaleKey::class);
    }
}
