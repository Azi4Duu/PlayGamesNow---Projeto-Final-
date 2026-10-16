<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\GamePlatform;
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

        foreach($cart->items as $item){
            $subtotal += $item->gamePlatform->price * $item->quantity;
        }

        return response()->json([
            'items' => CartItemResource::collection($cart->items),
            'subtotal' => $subtotal,
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
}
