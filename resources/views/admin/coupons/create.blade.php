@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Coupons',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Add Coupon'
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
                            <h2>Add coupon</h2>
                            <p>Create a new discount code.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control form-control-gk @error('code') is-invalid @enderror" placeholder="WELCOME10" value="{{ old('code') }}">
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
                                        <option value="">Select type</option>
                                        <option value="percentage"@selected(old('discount_type') == 'percentage')>Percentage</option>
                                        <option value="fixed"@selected(old('discount_type') == 'fixed')>Fixed</option>
                                    </select>
                                    @error('discount_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Discount value</label>
                                    <input type="number" step="0.01" min="0" name="discount_value" class="form-control form-control-gk @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}">
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
                                    <input type="date" name="starts_at" class="form-control form-control-gk @error('starts_at') is-invalid @enderror" value="{{ old('starts_at') }}">
                                    @error('starts_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Expires at</label>
                                    <input type="date" name="expires_at" class="form-control form-control-gk @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                                    @error('expires_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Usage limit</label>
                                <input type="number" min="1" name="usage_limit" class="form-control form-control-gk @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit') }}" placeholder="Leave empty for unlimited">
                                @error('usage_limit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="active" value="1"@checked(old('active'))>Active</label>
                            </div>
                            <button type="submit" class="btn-gk">Save coupon</button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn-gk light">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
