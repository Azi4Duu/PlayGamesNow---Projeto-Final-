@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Coupons',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Coupons'
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
                            <h2>Coupons</h2>
                            <p>Manage discount codes.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{ route('admin.coupons.create') }}">+ Add coupon</a>
                            <a class="btn-gk light" href="{{ route('admin.coupons.trashed') }}"><i class="fa-solid fa-trash"></i>Show Trashed</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Expires</th>
                                    <th>Status</th>
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
                                        <td>
                                            @if($coupon->expires_at)
                                                {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}
                                            @else
                                                No expiry
                                            @endif
                                        </td>
                                        <td>
                                            @if($coupon->active)
                                                <span class="status status-active">Active</span>
                                            @else
                                                <span class="status status-inactive">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a class="icon-action" href="{{ route('admin.coupons.edit', $coupon) }}"><i class="fa fa-pen"></i></a>
                                                <button type="button" class="icon-action" data-bs-toggle="modal" data-bs-target="#deleteCouponModal{{ $coupon->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="modal fade" id="deleteCouponModal{{ $coupon->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete coupon</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete<strong> {{ $coupon->code }}</strong>?</p>
                                                            <p class="text-muted mb-0">You can restore this coupon later.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete coupon</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
