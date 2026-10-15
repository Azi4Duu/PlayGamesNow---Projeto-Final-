@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Sale Details',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Sales / #' . $sale->id
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="admin-section">
        <div class="container">
            <div class="admin-shell">
                @include('layout.parts.admin-sidebar')
                <main class="admin-main">
                    <div class="admin-card">
                        <div class="sale-section">
                            <h4>Order information</h4>
                            <div class="sale-info-grid">
                                <p><strong>Customer:</strong> {{ $sale->user->name }}</p>
                                <p><strong>Email:</strong> {{ $sale->user->email }}</p>
                                <p><strong>Date:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($sale->status) }}</p>
                                <p><strong>Payment method:</strong> {{ ucfirst($sale->payment_method) }}</p>
                            </div>
                        </div>
                        <div class="sale-section">
                            <h4>Items</h4>
                            <div class="table-wrap">
                                <table class="gk-table">
                                    <thead>
                                    <tr>
                                        <th>Game</th>
                                        <th>Platform</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Keys</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sale->items as $item)
                                        <tr>
                                            <td>{{ $item->gamePlatform->game->title }}</td>
                                            <td>{{ $item->gamePlatform->platform->platform_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->unit_price, 2) }}€</td>
                                            <td>
                                                @foreach($item->saleKeys as $saleKey)
                                                    <div>
                                                        <code>{{ $saleKey->gameKey->code }}</code>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="sale-summary">
                            <div class="sale-summary-row">
                                <span>Subtotal</span>
                                <strong>{{ number_format($sale->subtotal, 2) }}€</strong>
                            </div>
                            <div class="sale-summary-row">
                                <span>Discount</span>
                                <strong>{{ number_format($sale->discount, 2) }}€</strong>
                            </div>
                            <div class="sale-summary-row total">
                                <span>Total</span>
                                <strong>{{ number_format($sale->total, 2) }}€</strong>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
