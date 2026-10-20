@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Sales',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Sales'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="admin-section">
        <div class="container">
            <div class="admin-shell">
                @include('layout.parts.admin-sidebar')
                <main class="admin-main">
                    <div class="admin-top">
                        <div>
                            <h2>Sales</h2>
                            <p>View all customer purchases.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.sales.index') }}">
                                <input type="text" name="search" placeholder="Search order or user..." class="form-control-gk" >
                                <select name="status" class="form-select-gk">
                                    <option value="">All status</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                                <select name="payment_method" class="form-select-gk">
                                    <option value="">All payment methods</option>
                                    <option value="card">Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="mbway">MB WAY</option>
                                </select>
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sales as $sale)
                                    <tr>
                                        <td>#{{ $sale->id }}</td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                                        <td>{{ number_format($sale->total, 2) }}€</td>
                                        <td>{{ ucfirst($sale->payment_method) }}</td>
                                        <td>
                                            <span class="status {{ $sale->status }}">
                                                {{ ucfirst($sale->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a class="icon-action" href="{{ route('admin.sales.show', $sale) }}" title="View sale"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <ul class="pagination">
                        @if($sales->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $sales->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $sales->lastPage(); $page++)
                            <li><a href="{{ $sales->url($page) }}" class="{{ $sales->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($sales->hasMorePages())
                            <li><a href="{{ $sales->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>

@endsection
