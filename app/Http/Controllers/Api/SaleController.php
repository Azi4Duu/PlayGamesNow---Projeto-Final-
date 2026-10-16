<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleCheckoutResource;
use App\Http\Resources\SaleResource;
use App\Http\Resources\SaleSummaryResource;
use App\Models\Cart;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleKey;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sale::where('user_id', $request->user()->id)->latest()->get();

        return SaleSummaryResource::collection($sales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,paypal,mbway',
            'cardholder_name' => 'required_if:payment_method,card|nullable|string|max:255',
            'card_number' => 'required_if:payment_method,card|nullable|regex:/^[0-9]{16}$/',
            'expiry_date' => 'required_if:payment_method,card|nullable|date_format:Y-m',
            'cvv' => 'required_if:payment_method,card|nullable|regex:/^[0-9]{3,4}$/',
            'paypal_email' => 'required_if:payment_method,paypal|nullable|email',
            'mbway_phone' => 'required_if:payment_method,mbway|nullable|regex:/^9[0-9]{8}$/',
        ]);

        $cart = Cart::where('user_id', $request->user()->id)->latest()->first();

        if(!$cart || $cart->items->count() < 1){
            return response()->json(['message' => 'Your cart is empty'], 422);
        }

        foreach($cart->items as $item){
            $availableKeys = $item->gamePlatform->gameKeys()->where('status', 'available')->count();

            if($item->quantity > $availableKeys){
                return response()->json(['message' => 'There is not enough stock available for ' . $item->gamePlatform->game->title . '.'], 422);
            }
        }

        $subtotal = 0;

        foreach($cart->items as $item){
            $subtotal += $item->gamePlatform->price * $item->quantity;
        }

        $discount = 0;

        $total = $subtotal - $discount;

        $sale = Sale::create([
            'user_id' => $request->user()->id,
            'coupon_id' => null,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'payment_reference' => null,
        ]);

        foreach($cart->items as $item){
            $saleItem = SaleItem::create([
                'sale_id' => $sale->id,
                'game_platform_id' => $item->game_platform_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->gamePlatform->price,
            ]);

            $gameKeys = $item->gamePlatform->gameKeys()->where('status', 'available')->take($item->quantity)->get();

            foreach($gameKeys as $gameKey){
                SaleKey::create([
                    'sale_item_id' => $saleItem->id,
                    'game_key_id' => $gameKey->id,
                ]);

                $gameKey->status = 'sold';
                $gameKey->sold_at = now();
                $gameKey->save();
            }
        }

        $cart->status = 'converted';
        $cart->save();

        $sale->load([
            'items.gamePlatform.game',
            'items.gamePlatform.platform',
            'items.saleKeys.gameKey',
        ]);

        return response()->json(['message' => 'Purchase completed successfully.', 'sale' => new SaleCheckoutResource($sale)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Sale $sale)
    {
        if($sale->user_id != $request->user()->id){
            return response()->json(['message' => 'You are not authorized to view this purchase.'], 403);
        }

        $sale->load([
            'items.gamePlatform.game',
            'items.gamePlatform.platform',
            'items.saleKeys.gameKey',
        ]);

        return new SaleResource($sale);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
