<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\CartItem;
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
        if ($this->game->image_path) {
            $image = asset('storage/' . $this->game->image_path);
        }
        elseif ($this->game->image_url) {
            $image = $this->game->image_url;
        }
        else {
            $image = asset('assets/images/default-game.png');
        }

        if ($this->platform->icon_path) {
            $platformIcon = asset('storage/' . $this->platform->icon_path);
        }
        else {
            $platformIcon = null;
        }

        $availableKeys = $this->gameKeys()
            ->where('status', 'available')
            ->count();

        $user = $request->user('sanctum');

        $quantityInCart = 0;

        if ($user) {

            $cart = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if ($cart) {

                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('game_platform_id', $this->id)
                    ->first();

                if ($cartItem) {
                    $quantityInCart = $cartItem->quantity;
                }
            }
        }

        $remainingStock = max(0, $availableKeys - $quantityInCart);

        return [
            'id' => $this->id,

            'game' => [
                'id' => $this->game->id,
                'title' => $this->game->title,
                'description' => $this->game->description,
                'release_date' => $this->game->release_date,
                'image' => $image,

                'categories' => $this->game->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->category_name,
                    ];
                })
            ],

            'platform' => [
                'id' => $this->platform->id,
                'name' => $this->platform->platform_name,
                'icon' => $platformIcon,
            ],

            'price' => $this->price,
            'old_price' => $this->old_price,
            'active' => $this->active,
            'stock' => $remainingStock,
        ];
    }
}
