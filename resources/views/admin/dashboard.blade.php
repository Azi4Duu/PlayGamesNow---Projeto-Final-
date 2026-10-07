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
                            <strong>316</strong>
                        </div>
                        <div class="stat-card">
                            <span>Revenue</span>
                            <strong>€8.4K</strong>
                        </div>
                    </div>
                    <div class="admin-card">
                        <h3>Recent sales</h3>
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
                                <tr>
                                    <td>#1042</td>
                                    <td>Maria Silva</td>
                                    <td>€39.99</td>
                                    <td><span class="status paid">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>#1041</td>
                                    <td>João Costa</td>
                                    <td>€24.99</td>
                                    <td><span class="status pending">Pending</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
