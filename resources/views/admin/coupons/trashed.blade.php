@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Coupons',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Trashed Coupons'
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
                            <h2>Trashed Coupons</h2>
                            <p>Restore deleted discount codes.</p>
                        </div>
                        <a class="btn-gk light" href="{{ route('admin.coupons.index') }}">Back to coupons</a>
                    </div>
                    <div class="admin-card">
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Deleted at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $coupon)
                                    <tr>
                                        <td><strong>{{ $coupon->code }}</strong></td>
                                        <td>{{ ucfirst($coupon->discount_type) }}</td>
                                        <td>
                                            @if($coupon->discount_type == 'percentage')
                                                {{ number_format($coupon->discount_value, 0) }}%
                                            @else
                                                {{ number_format($coupon->discount_value, 2) }}€
                                            @endif
                                        </td>
                                        <td>{{ $coupon->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.coupons.restore', $coupon->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="icon-action" title="Restore"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                            </form>
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
