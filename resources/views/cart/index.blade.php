@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Shopping Cart',
        'breadcrumbs' => [
            [
            'label' => 'Cart'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="cart-section">
        <div class="container">

            <div class="cart-grid">

                <div class="content-card">

                    <h3>Your cart</h3>

                    @if($cart && count($cart->items))
                        @foreach($cart->items as $item)
                            <div class="cart-item">
                                <img src="{{ $item->gamePlatform->game->display_image }}" alt="{{ $item->gamePlatform->game->title }}">
                                <div>
                                    <h5>{{$item->gamePlatform->game->title}}</h5>
                                    <span>{{$item->gamePlatform->platform->platform_name}}</span>

                                    <div>
                                        <form action="{{route('customer.cart.update', $item)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input
                                                class="qty"
                                                type="number"
                                                name="quantity"
                                                value="{{$item->quantity}}"
                                                min="1"
                                                max="{{ $item->gamePlatform->gameKeys()->where('status', 'available')->count() }}"
                                            >
                                            <button type="submit" class="btn-gk">Update</button>
                                        </form>
                                    </div>
                                </div>

                                <div>
                                    <strong>€{{number_format($item->gamePlatform->price * $item->quantity, 2)}}</strong>
                                    <br>
                                    <form action="{{route('customer.cart.destroy', $item)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> Remove</button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>

                <aside class="content-card">
                    <h3>Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>{{ number_format($subtotal, 2) }}€</span>
                    </div>
                    <div class="summary-row">
                        <span>Discount</span>
                        <span>-{{ number_format($discount, 2) }}€</span>
                    </div>
                    @if($cart && $cart->coupon)

                        <div class="form-group">
                            <label>Applied coupon</label>
                            <div>
                                <strong>{{ $cart->coupon->code }}</strong>
                                @if($cart->coupon->discount_type === 'percentage')
                                    ({{ number_format($cart->coupon->discount_value, 0) }}%)
                                @else
                                    ({{ number_format($cart->coupon->discount_value, 2) }}€)
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('customer.cart.coupon.remove') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-gk light full">
                                Remove coupon
                            </button>
                        </form>
                    @else
                        <form action="{{ route('customer.cart.coupon.apply') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="form-control-gk @error('coupon_code') is-invalid @enderror" name="coupon_code" placeholder="Coupon code" value="{{ old('coupon_code') }}">
                                @error('coupon_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-gk light full">
                                Apply coupon
                            </button>
                        </form>

                    @endif

                    <div class="summary-row total">
                        <span>Total</span>
                        <span>{{ number_format($total, 2) }}€</span>
                    </div>
                    <a class="btn-gk full" href="{{route('customer.checkout.create')}}">Checkout</a>
                </aside>
            </div>
        </div>
    </section>
@endsection
