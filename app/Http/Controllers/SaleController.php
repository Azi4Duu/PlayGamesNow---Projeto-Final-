<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

        return view('checkout.create', compact('cart', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
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
}
