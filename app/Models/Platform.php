<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Platform extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'platform_name',
        'icon_path',
    ];

    public function gamePlatforms():HasMany{
        return $this->hasMany(GamePlatform::class);
    }

    public function games():BelongsToMany{
        return $this->belongsToMany(Game::class, 'game_platforms')
            ->withPivot('price', 'old_price', 'active')
            ->withTimestamps();
    }
}
