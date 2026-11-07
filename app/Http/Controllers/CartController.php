<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->where('status', 'active')->first();

        $subtotal = 0;
        $discount = 0;
        $total = 0;

        if ($cart) {
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
        }

        return view('cart.index', compact('cart', 'subtotal', 'discount', 'total'));
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
        if($cartItem->cart->user_id != auth()->id()){
            abort(403);
        }

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
        if($cartItem->cart->user_id != auth()->id()){
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('customer.cart.index')->with('success', 'Game removed from cart successfully.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:255',
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->withErrors(['coupon_code' => 'Your cart is empty.']);
        }

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
            ->first();

        if (!$coupon) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'Invalid coupon code.']);
        }

        if (!$coupon->active) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'This coupon is not active.']);
        }

        if ($coupon->starts_at && now()->lt($coupon->starts_at)) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'This coupon is not active yet.']);
        }

        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'This coupon has expired.']);
        }

        if ($coupon->usage_limit !== null) {
            $usageCount = Sale::where('coupon_id', $coupon->id)
                ->where('status', 'paid')
                ->count();

            if ($usageCount >= $coupon->usage_limit) {
                return back()
                    ->withInput()
                    ->withErrors(['coupon_code' => 'This coupon has reached its usage limit.']);
            }
        }

        $cart->coupon_id = $coupon->id;
        $cart->save();

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Coupon applied successfully.');
    }

    public function removeCoupon()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($cart) {
            $cart->coupon_id = null;
            $cart->save();
        }

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Coupon removed successfully.');
    }
}
