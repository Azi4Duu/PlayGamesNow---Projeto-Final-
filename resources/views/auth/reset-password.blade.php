@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Reset password',
        'breadcrumbs' => [
            ['label' => 'Reset password']
        ]
    ])

    <section class="auth-section">
        <div class="container">

            <div class="auth-card">

                <h3>Choose a new password</h3>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input
                        type="hidden"
                        name="token"
                        value="{{ $token }}"
                    >

                    <input
                        type="hidden"
                        name="email"
                        value="{{ $email }}"
                    >

                    <div class="form-group">
                        <label for="password">New password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control form-control-gk @error('password') is-invalid @enderror"
                        >

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">
                            Confirm new password
                        </label>

                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            class="form-control form-control-gk @error('confirm_password') is-invalid @enderror"
                        >

                        @error('confirm_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-gk full">
                        Reset password
                    </button>
                </form>

            </div>

        </div>
    </section>

@endsection
