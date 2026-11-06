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
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.coupons.trashed') }}">
                                <input type="text" name="search" placeholder="Search coupons..." class="form-control-gk" value="{{ request('search') }}">
                                <select name="discount_type" class="form-select-gk">
                                    <option value="">All types</option>
                                    <option value="percentage" @selected(request('discount_type') === 'percentage')>Percentage</option>
                                    <option value="fixed" @selected(request('discount_type') === 'fixed')>Fixed</option>
                                </select>
                                <select name="active" class="form-select-gk">
                                    <option value="">All status</option>
                                    <option value="1" @selected(request('active') === '1')>Active</option>
                                    <option value="0" @selected(request('active') === '0')>Inactive</option>
                                </select>
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <a href="{{ route('admin.coupons.trashed') }}" class="btn-gk light">Clear Filters</a>
                            </form>
                        </div>
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
                    <ul class="pagination">
                        @if($coupons->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $coupons->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $coupons->lastPage(); $page++)
                            <li><a href="{{ $coupons->url($page) }}" class="{{ $coupons->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($coupons->hasMorePages())
                            <li><a href="{{ $coupons->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>

@endsection
