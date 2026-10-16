<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GamePlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'game' => [
                'id' => $this->game->id,
                'title' => $this->game->title,
                'description' => $this->game->description,
                'release_date' => $this->game->release_date,
                'image_url' => $this->game->image_url,
                'image_path' => $this->game->image_path,
            ],
            'platform' => [
                'id' => $this->platform->id,
                'name' => $this->platform->platform_name,
                'icon_path' => $this->platform->icon_path,
            ],
            'price' => $this->price,
            'old_price' => $this->old_price,
            'active' => $this->active,
            'stock' => $this->gameKeys()->where('status', 'available')->count(),
        ];
    }
}
