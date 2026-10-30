<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->gamePlatform->game->image_path){
            $image = asset('storage/' . $this->gamePlatform->game->image_path);
        }
        elseif($this->gamePlatform->game->image_url){
            $image = $this->gamePlatform->game->image_url;
        }
        else{
            $image = '/assets/images/default-game.png';
        }

        $maxQuantity = $this->gamePlatform
            ->gameKeys()
            ->where('status', 'available')
            ->count();

        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'max_quantity' => $maxQuantity,
            'game_platform' => [
                'id' => $this->gamePlatform->id,
                'game' => [
                    'id' => $this->gamePlatform->game->id,
                    'title' => $this->gamePlatform->game->title,
                    'image' => $image,
                ],
                'platform' => [
                    'id' => $this->gamePlatform->platform->id,
                    'name' => $this->gamePlatform->platform->platform_name,
                ],
                'price' => $this->gamePlatform->price,
            ],
            'item_total' => $this->gamePlatform->price * $this->quantity,
        ];
    }
}
