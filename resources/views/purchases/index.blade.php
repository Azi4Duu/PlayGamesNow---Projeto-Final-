@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'My Purchases',
        'breadcrumbs' => [
            [
                'label' => 'Profile / Purchases'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="profile-section">
        <div class="container">
            <div class="content-card">
                <h3>Purchase history</h3>
                <p class="intro">View your previous orders and purchased game keys.</p>
                <div class="admin-filter">
                    <form method="GET" action="{{ route('customer.purchases.index') }}">
                        <input type="text" name="sale_id" placeholder="Search order ..." class="form-control-gk" >
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
                @if($sales->count())
                    <div class="table-wrap">
                        <table class="gk-table">
                            <thead>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>#{{$sale->id}}</td>
                                    <td>{{$sale->created_at->format('d/m/y')}}</td>
                                    <td>{{number_format($sale->total, 2)}}€</td>
                                    <td><span class="status {{$sale->status}}">{{ucfirst($sale->status)}}</span></td>
                                    <td><a href="{{route('customer.purchases.show', $sale)}}">View</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No purchases found.</p>
                @endif
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
        </div>
    </section>
@endsection
