<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\GamePlatform;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->where('status', 'active')->first();

        $total = 0;

        if($cart){
            foreach($cart->items as $item){
                $subtotal = $item->gamePlatform->price * $item->quantity;
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GamePlatform $gamePlatform)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $availableKeys = $gamePlatform->gameKeys()->where('status', 'available')->count();

        if($request->quantity > $availableKeys){
            return back()->withErrors(['error' => 'There is not enough stock available.']);
        }

        $cart = Cart::where('user_id', auth()->id())->where('status', 'active')->first();

        if(!$cart){
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'status' => 'active',
            ]);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)->where('game_platform_id', $gamePlatform->id)->first();

        if($cartItem){
            $newQuantity = $cartItem->quantity + $request->quantity;

            if($newQuantity > $availableKeys){
                return back()->withErrors(['error' => 'There is not enough stock available.']);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        }
        else{

            if($request->quantity > $availableKeys){
                return back()->withErrors(['error' => 'There is not enough stock available.']);
            }

            CartItem::create([
               'cart_id' => $cart->id,
               'game_platform_id' => $gamePlatform->id,
               'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Game added to cart successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $availableKeys = $cartItem->gamePlatform->gameKeys()->where('status', 'available')->count();

        if($request->quantity > $availableKeys){
            return back()->withErrors(['error' => 'There is not enough stock available.']);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('customer.cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('customer.cart.index')->with('success', 'Game removed from cart successfully.');
    }
}
