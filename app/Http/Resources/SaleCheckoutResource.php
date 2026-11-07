<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleCheckoutResource extends JsonResource
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
            'coupon' => $this->coupon ? [
                'code' => $this->coupon->code,
                'discount_type' => $this->coupon->discount_type,
                'discount_value' => $this->coupon->discount_value,
            ] : null,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'items' => $this->items->map(function ($item) {
                return [
                    'title' => $item->gamePlatform->game->title,
                    'platform' => $item->gamePlatform->platform->platform_name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'item_total' => $item->unit_price * $item->quantity,
                    'keys' => $item->saleKeys->map(function ($saleKey) {
                        return ['code' => $saleKey->gameKey->code,];
                    }),
                ];
            }),
        ];
    }
}
