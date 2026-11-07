<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\GamePlatform;
use App\Models\Sale;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->where('status', 'active')->first();

        if(!$cart){
            return response()->json([
               'items' => [],
               'subtotal' => 0,
            ]);
        }

        $subtotal = 0;
        $discount = 0;

        foreach ($cart->items as $item) {
            $subtotal += $item->gamePlatform->price * $item->quantity;
        }

        if ($cart->coupon) {
            if ($cart->coupon->discount_type === 'percentage') {
                $discount = $subtotal * ($cart->coupon->discount_value / 100);
            }

            if ($cart->coupon->discount_type === 'fixed') {
                $discount = $cart->coupon->discount_value;
            }

            $discount = min($discount, $subtotal);
        }

        $total = $subtotal - $discount;

        return response()->json([
            'items' => CartItemResource::collection($cart->items),

            'coupon' => $cart->coupon ? [
                'id' => $cart->coupon->id,
                'code' => $cart->coupon->code,
                'discount_type' => $cart->coupon->discount_type,
                'discount_value' => $cart->coupon->discount_value,
            ] : null,

            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_platform_id' => 'required|exists:game_platforms,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $gamePlatform = GamePlatform::findOrFail($request->game_platform_id);

        $availableKeys = $gamePlatform->gameKeys()->where('status', 'available')->count();

        if($request->quantity > $availableKeys){
            return response()->json([
                'message' => 'There is not enough stock available.'
            ], 422);
        }

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();

        if(!$cart){
            $cart = Cart::create([
                'user_id' => $request->user()->id,
                'status' => 'active',
            ]);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('game_platform_id', $gamePlatform->id)
            ->first();

        if($cartItem){

            $newQuantity = $cartItem->quantity + $request->quantity;

            if($newQuantity > $availableKeys){
                return response()->json([
                    'message' => 'There is not enough stock available.'
                ], 422);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();

        }else{

            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'game_platform_id' => $gamePlatform->id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'message' => 'Game added to cart successfully.',
            'item' => new CartItemResource($cartItem),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        if($cartItem->cart->user_id != $request->user()->id){
            return response()->json([
                'message' => 'You cannot edit this cart.',
            ], 403);
        }

        $request->validate([
           'quantity' => 'required|integer|min:1',
        ]);

        $availableKeys = $cartItem->gamePlatform->gameKeys()->where('status', 'available')->count();

        if($request->quantity > $availableKeys){
            return response()->json([
                'message' => 'There is not enough stock available.'
            ], 422);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'message' => 'Cart item updated successfully.',
            'item' => new CartItemResource($cartItem),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CartItem $cartItem)
    {
        if($cartItem->cart->user_id != $request->user()->id){
            return response()->json([
                'message' => 'You cannot edit this cart.',
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Cart item removed successfully.',
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:255',
        ]);

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty.'
            ], 422);
        }

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
            ->first();

        if (!$coupon) {
            return response()->json([
                'message' => 'Invalid coupon code.'
            ], 422);
        }

        if (!$coupon->active) {
            return response()->json([
                'message' => 'This coupon is not active.'
            ], 422);
        }

        if ($coupon->starts_at && now()->lt($coupon->starts_at)) {
            return response()->json([
                'message' => 'This coupon is not active yet.'
            ], 422);
        }

        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return response()->json([
                'message' => 'This coupon has expired.'
            ], 422);
        }

        if ($coupon->usage_limit !== null) {
            $usageCount = Sale::where('coupon_id', $coupon->id)
                ->where('status', 'paid')
                ->count();

            if ($usageCount >= $coupon->usage_limit) {
                return response()->json([
                    'message' => 'This coupon has reached its usage limit.'
                ], 422);
            }
        }

        $cart->coupon_id = $coupon->id;
        $cart->save();

        return response()->json([
            'message' => 'Coupon applied successfully.'
        ]);
    }

    public function removeCoupon(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();

        if ($cart) {
            $cart->coupon_id = null;
            $cart->save();
        }

        return response()->json([
            'message' => 'Coupon removed successfully.'
        ]);
    }
}
