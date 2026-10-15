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
                </main>
            </div>
        </div>
    </section>

@endsection
