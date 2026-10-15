@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Dashboard',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Dashboard'
            ]
        ]
    ])

    <section class="admin-section">
        <div class="container">
            <div class="admin-shell">
                @include('layout.parts.admin-sidebar')
                <main class="admin-main">
                    <div class="admin-top">
                        <div>
                            <h2>Dashboard</h2>
                            <p>Overview of the GameKey Store.</p>
                        </div>
                    </div>
                    <div class="stat-grid">
                        <div class="stat-card">
                            <span>Users</span>
                            <strong>{{$users}}</strong>
                        </div>
                        <div class="stat-card">
                            <span>Games</span>
                            <strong>{{$games}}</strong>
                        </div>
                        <div class="stat-card">
                            <span>Sales</span>
                            <strong>{{$sales}}</strong>
                        </div>
                        <div class="stat-card">
                            <span>Revenue</span>
                            <strong>
                                @if($revenue >= 1000)
                                    {{ number_format($revenue / 1000, 1, ',', '.') }}K€
                                @else
                                    {{ number_format($revenue, 2, ',', '.') }}€
                                @endif
                            </strong>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h3>Recent sales</h3>
                            <a href="{{ route('admin.sales.index') }}" class="btn-gk">View all sales</a>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentSales as $sale)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.sales.show', $sale)}}">#{{$sale->id}}</a>
                                        </td>
                                        <td>{{$sale->user->name}}</td>
                                        <td>{{number_format($sale->total, 2)}}€</td>
                                        <td><span class="status {{$sale->status}}">{{ucfirst($sale->status)}}</span></td>
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
