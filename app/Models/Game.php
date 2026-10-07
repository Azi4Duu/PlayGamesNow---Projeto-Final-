<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'publisher_id',
        'rawg_id',
        'title',
        'description',
        'release_date',
        'image_url',
        'image_path',
    ];

    public function publisher():BelongsTo{
        return $this->belongsTo(Publisher::class);
    }

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class, 'game_category');
    }

    public function gamePlatforms():HasMany{
        return $this->hasMany(GamePlatform::class);
    }

    public function platforms():BelongsToMany{
        return $this->belongsToMany(Platform::class, 'game_platforms')
            ->withPivot('price', 'old_price', 'active')
            ->withTimestamps();
    }


}
