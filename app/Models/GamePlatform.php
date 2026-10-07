<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GamePlatform extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'game_id',
        'platform_id',
        'price',
        'old_price',
        'active',
    ];

    public function game():belongsTo{
        return $this->belongsTo(Game::class);
    }

    public function platform():belongsTo{
        return $this->belongsTo(Platform::class);
    }

    public function gameKeys():HasMany{
        return $this->hasMany(GameKey::class);
    }

    public function cartItems():HasMany{
        return $this->hasMany(CartItem::class);
    }

    public function saleItems():HasMany{
        return $this->hasMany(SaleItem::class);
    }
}
