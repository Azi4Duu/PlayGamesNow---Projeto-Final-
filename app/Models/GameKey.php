<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GameKey extends Model
{
    protected $fillable = [
        'game_platform_id',
        'code',
        'status',
        'sold_at',
    ];
    public function gamePlatform():BelongsTo{
        return $this->belongsTo(GamePlatform::class);
    }
    public function saleKey():HasOne{
        return $this->hasOne(SaleKey::class);
    }
}
