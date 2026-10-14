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
            <form action="{{route('customer.checkout.create')}}" method="GET">
                <div class="form-group">
                    <div class="cart-grid">
                        <div class="content-card">
                            <h3>Payment details</h3>
                            <p class="intro">Choose how you want to complete your purchase.</p>
                            <label>Payment method</label>
                            <div class="payment-method-row">
                                <select id="payment_method" class="form-control form-select-gk @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                    <option value="">Select a payment method</option>
                                    <option value="card" @selected($selectedMethod === 'card')>Card</option>
                                    <option value="paypal" @selected($selectedMethod === 'paypal')>PayPal</option>
                                    <option value="mbway" @selected($selectedMethod === 'mbway')>MB WAY</option>
                                </select>
                                <div class="form-group d-flex align-items-end">
                                    <button type="submit" class="btn-gk">Select</button>
                                </div>
                            </div>
                            @error('payment_method')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
            @if($selectedMethod)
                <form action="{{route('customer.checkout.store')}}" method="POST">
                    @csrf
                    <div class="cart-grid">
                        <div class="content-card">
                            <input type="hidden" name="payment_method" value="{{ $selectedMethod }}">
                            @if($selectedMethod === 'card')
                                <h3>Card details</h3>
                                <p class="intro">Enter your card details.</p>
                                <div class="form-row-gk">
                                    <div class="form-group">
                                        <label>Cardholder name</label>
                                        <input name="cardholder_name" class="form-control form-control-gk @error('cardholder_name') is-invalid @enderror" placeholder="Name on card" value="{{old('cardholder_name')}}">
                                        @error('cardholder_name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Card number</label>
                                        <input inputmode="numeric" maxlength="16" name="card_number" class="form-control form-control-gk @error('card_number') is-invalid @enderror" placeholder="0000000000000000" value="{{old('card_number')}}">
                                        @error('card_number')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row-gk">
                                    <div class="form-group">
                                        <label>Expiry</label>
                                        <input type="month" name="expiry_date" class="form-control form-control-gk @error('expiry_date') is-invalid @enderror" placeholder="MM/YY" value="{{old('expiry_date')}}">
                                        @error('expiry_date')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>CVV</label>
                                        <input inputmode="numeric" name="cvv" class="form-control form-control-gk @error('cvv') is-invalid @enderror" placeholder="123" maxlength="4">
                                        @error('cvv')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if($selectedMethod === 'paypal')
                                <h3>PayPal details</h3>
                                <p class="intro">Enter your PayPal account email.</p>
                                <div class="form-group">
                                    <label>PayPal email</label>
                                    <input type="email" name="paypal_email" class="form-control form-control-gk @error('paypal_email') is-invalid @enderror" placeholder="email@example.com" value="{{ old('paypal_email') }}">
                                    @error('paypal_email')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            @endif
                            @if($selectedMethod === 'mbway')
                                <h3>MB WAY details</h3>
                                <p class="intro">Enter the phone number associated with your MB WAY account.</p>
                                <div class="form-group">
                                    <label>Phone number</label>
                                    <input type="text" name="mbway_phone" inputmode="numeric" maxlength="9" class="form-control form-control-gk @error('mbway_phone') is-invalid @enderror" placeholder="9XXXXXXXX" value="{{ old('mbway_phone') }}">
                                    @error('mbway_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
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
                </form>
            @endif
        </div>
    </section>
@endsection
