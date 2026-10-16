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
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'game_platform' => [
                'id' => $this->gamePlatform->id,
                'game' => [
                    'id' => $this->gamePlatform->game->id,
                    'title' => $this->gamePlatform->game->title,
                    'image_url' => $this->gamePlatform->game->image_url,
                    'image_path' => $this->gamePlatform->game->image_path,
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
