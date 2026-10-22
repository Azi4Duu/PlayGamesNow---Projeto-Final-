<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total' => $this->total,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at,
            'items' => $this->items->map(function ($item) {

                if($item->gamePlatform->game->image_path){
                    $image = '/storage/' . $item->gamePlatform->game->image_path;
                }
                elseif($item->gamePlatform->game->image_url){
                    $image = $item->gamePlatform->game->image_url;
                }
                else{
                    $image = '/assets/images/default-game.png';
                }

                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'game' => [
                        'id' => $item->gamePlatform->game->id,
                        'title' => $item->gamePlatform->game->title,
                        'image' => $image,
                    ],
                    'platform' => [
                        'id' => $item->gamePlatform->platform->id,
                        'name' => $item->gamePlatform->platform->platform_name,
                    ],
                    'keys' => $item->saleKeys->map(function ($saleKey) {
                        return [
                            'id' => $saleKey->gameKey->id,
                            'code' => $saleKey->gameKey->code,
                        ];
                    }),
                ];
            }),
        ];
    }
}
