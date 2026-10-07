<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'publisher_name',
        'website',
        'country',
    ];

    public function games():HasMany{
        return $this->hasMany(Game::class);
    }
}
