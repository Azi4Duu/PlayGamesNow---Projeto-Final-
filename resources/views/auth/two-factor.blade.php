@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Two-Factor Authentication',
        'breadcrumbs' => [
            ['label' => '2FA']
        ]
    ])

    <section class="auth-section">
        <div class="container">

            <div class="auth-card">

                <h3>Authentication code</h3>

                <p class="intro">
                    We sent a 6-digit code to your email.
                </p>

                <form action="{{ route('2fa.verify') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="code">Code</label>

                        <input
                            type="text"
                            id="code"
                            name="code"
                            maxlength="6"
                            class="form-control form-control-gk @error('code') is-invalid @enderror"
                        >

                        @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-gk full">
                        Verify
                    </button>
                </form>

            </div>

        </div>
    </section>

@endsection
