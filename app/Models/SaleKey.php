<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleKey extends Model
{
    protected $fillable = [
        'sale_item_id',
        'game_key_id',
    ];

    public function saleItem():BelongsTo{
        return $this->belongsTo(SaleItem::class);
    }

    public function gameKey():BelongsTo{
        return $this->belongsTo(GameKey::class);
    }
}
