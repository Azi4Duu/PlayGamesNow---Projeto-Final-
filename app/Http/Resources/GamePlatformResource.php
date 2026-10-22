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
        if($this->game->image_path){
            $image = '/storage/' . $this->game->image_path;
        }
        elseif($this->game->image_url){
            $image = $this->game->image_url;
        }
        else{
            $image = '/assets/images/default-game.png';
        }

        if($this->platform->icon_path){
            $platformIcon = '/storage/' . $this->platform->icon_path;
        }
        else{
            $platformIcon = null;
        }

        return [
            'id' => $this->id,
            'game' => [
                'id' => $this->game->id,
                'title' => $this->game->title,
                'description' => $this->game->description,
                'release_date' => $this->game->release_date,
                'image' => $image,
            ],
            'platform' => [
                'id' => $this->platform->id,
                'name' => $this->platform->platform_name,
                'icon' => $platformIcon,
            ],
            'price' => $this->price,
            'old_price' => $this->old_price,
            'active' => $this->active,
            'stock' => $this->gameKeys()->where('status', 'available')->count(),
        ];
    }
}
