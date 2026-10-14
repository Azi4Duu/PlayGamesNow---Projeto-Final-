@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Purchase Details',
        'breadcrumbs' => [
            [
            'label' => 'Profile / Purchase'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="profile-section">
        <div class="container">
            <div class="content-card">
                <div class="admin-top">
                    <div>
                        <h3>Order #{{$sale->id}}</h3>
                        <p class="intro">Placed on {{$sale->created_at->format('d/m/Y')}}</p>
                    </div>
                    <span class="status {{$sale->status}}">{{ucfirst($sale->status)}}</span>
                </div>
                <div class="table-wrap">
                    <table class="gk-table">
                        <thead>
                        <tr>
                            <th>Game</th>
                            <th>Platform</th>
                            <th>Price</th>
                            <th>Game Key</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sale->items as $item)
                            <tr>
                                <td>{{$item->gamePlatform->game->title}}</td>
                                <td>{{$item->gamePlatform->platform->platform_name}}</td>
                                <td>{{number_format($item->unit_price, 2)}}€</td>
                                <td>
                                    @foreach($item->saleKeys as $saleKey)
                                        <code>{{$saleKey->gameKey->code}}</code>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>{{number_format($sale->total, 2)}}€</span>
                </div>
            </div>
        </div>
    </section>
@endsection
