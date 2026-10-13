@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Checkout',
        'breadcrumbs' => [
            [
            'label' => 'Cart/Chekout'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="cart-section">
        <div class="container">
            <div class="cart-grid">
                <div class="content-card">
                    <h3>Payment details</h3>
                    <p class="intro">Choose how you want to complete your purchase.</p>
                    <div class="form-group">
                        <label>Payment method</label>
                        <select class="form-select-gk">
                            <option>Card</option>
                            <option>PayPal</option>
                            <option>MB WAY</option>
                        </select>
                    </div>
                    <div class="form-row-gk">
                        <div class="form-group">
                            <label>Cardholder name</label>
                            <input class="form-control-gk" placeholder="Name on card">
                        </div>
                        <div class="form-group">
                            <label>Card number</label>
                            <input class="form-control-gk" placeholder="0000 0000 0000 0000">
                        </div>
                    </div>
                    <div class="form-row-gk">
                        <div class="form-group">
                            <label>Expiry</label>
                            <input class="form-control-gk" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input class="form-control-gk" placeholder="123">
                        </div>
                    </div>
                </div>
                <aside class="content-card">
                    <h3>Order summary</h3>
                    @foreach($cart->items as $item)
                        <div class="checkout-product">
                            <div class="checkout-product-info">
                                <strong>{{ $item->gamePlatform->game->title }}</strong>
                                <span>{{ $item->gamePlatform->platform->platform_name }}</span>
                                <span>Quantity: {{ $item->quantity }}</span>
                            </div>
                            <div class="checkout-product-price">
                                {{number_format($item->gamePlatform->price * $item->quantity,2)}}€
                            </div>
                        </div>
                    @endforeach
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>{{number_format($total, 2)}}€</span>
                    </div>
                    <div class="summary-row">
                        <span>Discount</span>
                        <span>0.00€</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>{{number_format($total, 2)}}€</span>
                    </div>
                    <button type="submit" class="btn-gk full">Pay now</button>
                </aside>
            </div>
        </div>
    </section>
@endsection
