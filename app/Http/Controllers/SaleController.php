<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\GameKey;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleKey;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::where('user_id', auth()->id())->latest()->get();
        return view('purchases.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if(!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->withErrors(['error' => 'Your cart is empty.']);
        }

        $total = 0;

        foreach($cart->items as $item) {
            $subtotal = $item->gamePlatform->price * $item->quantity;
            $total += $subtotal;
        }

        $selectedMethod = $request->payment_method;

        if($selectedMethod && !in_array($selectedMethod, ['card', 'paypal', 'mbway'])){
            return redirect()->route('customer.checkout.create')
                ->withErrors([
                    'error' => 'Invalid payment method.'
                ]);
        }

        return view('checkout.create', compact('cart', 'total', 'selectedMethod'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:paypal,card,mbway',
            'cardholder_name' => 'required_if:payment_method,card|nullable|string|max:255',
            'card_number' => 'required_if:payment_method,card|nullable|regex:/^[0-9]{16}$/',
            'expiry_date' => 'required_if:payment_method,card|nullable|date_format:Y-m',
            'cvv' => 'required_if:payment_method,card|nullable|regex:/^[0-9]{3,4}$/',
            'paypal_email' => 'required_if:payment_method,paypal|nullable|email',
            'mbway_phone' => 'required_if:payment_method,mbway|nullable|regex:/^9[0-9]{8}$/',
        ]);

        $cart = Cart::where('user_id', auth()->id())->where('status', 'active')->first();

        if(!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart.index')->withErrors(['error' => 'Your cart is empty.']);
        }

        $subtotal = 0;

        foreach($cart->items as $item) {

            $availableKeys = $item->gamePlatform->gameKeys()->where('status', 'available')->count();

            if($item->quantity > $availableKeys) {
                return redirect()->route('customer.cart.index')->withErrors(['error' => 'One or more games no longer have enough stock.']);
            }

            $subtotal += $item->gamePlatform->price * $item->quantity;
        }

        $discount = 0;

        $total = $subtotal - $discount;

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'coupon_id' => null,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'payment_reference' => null,
        ]);

        foreach($cart->items as $item) {
            $saleItem = SaleItem::create([
                'sale_id' => $sale->id,
                'game_platform_id' => $item->game_platform_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->gamePlatform->price,
            ]);

            $keys = GameKey::where('game_platform_id', $item->game_platform_id)->where('status', 'available')->take($item->quantity)->get();

            foreach($keys as $key) {
                SaleKey::create([
                   'sale_item_id' => $saleItem->id,
                   'game_key_id' => $key->id,
                ]);

                $key->status = 'sold';
                $key->sold_at = now();
                $key->save();
            }
        }

        $cart->status = 'converted';
        $cart->save();

        return redirect()->route('customer.purchases.show', $sale)->with('success', 'Purchase completed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        if($sale->user_id != auth()->id()) {
            abort(403);
        }

        return view('purchases.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function success(Sale $sale)
    {

    }
}
