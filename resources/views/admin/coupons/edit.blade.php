@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Coupons',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Edit Coupon'
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
                            <h2>Edit coupon</h2>
                            <p>Update discount code information.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control form-control-gk @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}">
                                @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-row-gk">
                                <div class="form-group">
                                    <label>Discount type</label>
                                    <select name="discount_type" class="form-select-gk @error('discount_type') is-invalid @enderror">
                                        <option value="percentage"@selected(old('discount_type', $coupon->discount_type) == 'percentage')>Percentage</option>
                                        <option value="fixed"@selected(old('discount_type', $coupon->discount_type) == 'fixed')>Fixed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Discount value</label>
                                    <input type="number" step="0.01" min="0" name="discount_value" class="form-control form-control-gk @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', $coupon->discount_value) }}">
                                    @error('discount_value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row-gk">
                                <div class="form-group">
                                    <label>Starts at</label>
                                    <input type="date" name="starts_at" class="form-control form-control-gk @error('starts_at') is-invalid @enderror" value="{{ old('starts_at', $coupon->starts_at) }}">
                                </div>
                                <div class="form-group">
                                    <label>Expires at</label>
                                    <input type="date" name="expires_at" class="form-control form-control-gk @error('expires_at') is-invalid @enderror" value="{{ old('expires_at', $coupon->expires_at) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Usage limit</label>
                                <input type="number" min="1" name="usage_limit" class="form-control form-control-gk" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="active" value="1"@checked(old('active', $coupon->active))>Active</label>
                            </div>
                            <button type="submit" class="btn-gk">Update coupon</button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn-gk light">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
