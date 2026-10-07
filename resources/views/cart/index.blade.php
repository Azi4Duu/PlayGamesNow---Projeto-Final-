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

    <section class="cart-section">
        <div class="container">

            <div class="cart-grid">

                <div class="content-card">

                    <h3>Your cart</h3>

                    <div class="cart-item">

                        <img src="assets/images/trending-01.jpg" alt="">

                        <div>
                            <h5>Grand Theft Auto V</h5>
                            <span>Steam</span>

                            <div>
                                <input
                                    class="qty"
                                    type="number"
                                    value="1"
                                    min="1"
                                >
                            </div>
                        </div>

                        <div>
                            <strong>€19.99</strong>
                            <br>
                            <a href="#">Remove</a>
                        </div>

                    </div>

                    <div class="cart-item">

                        <img src="assets/images/trending-02.jpg" alt="">

                        <div>
                            <h5>The Witcher 3</h5>
                            <span>GOG</span>

                            <div>
                                <input
                                    class="qty"
                                    type="number"
                                    value="1"
                                    min="1"
                                >
                            </div>
                        </div>

                        <div>
                            <strong>€24.99</strong>
                            <br>
                            <a href="#">Remove</a>
                        </div>

                    </div>

                </div>

                <aside class="content-card">

                    <h3>Summary</h3>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>€44.98</span>
                    </div>

                    <div class="summary-row">
                        <span>Discount</span>
                        <span>€0.00</span>
                    </div>

                    <div class="form-group">
                        <input
                            class="form-control-gk"
                            placeholder="Coupon code"
                        >
                    </div>

                    <button class="btn-gk light full">
                        Apply coupon
                    </button>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span>€44.98</span>
                    </div>

                    <a
                        class="btn-gk full"
                        href="checkout.html"
                    >
                        Checkout
                    </a>

                </aside>

            </div>

        </div>
    </section>
@endsection
