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
                    <p>You haven't made any purchases yet.</p>
                @endif
            </div>
        </div>
    </section>

@endsection
