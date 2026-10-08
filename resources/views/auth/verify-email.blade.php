@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Verify your email',
        'breadcrumbs' => [
            [
                'label' => 'Verify email'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="auth-section">
        <div class="container">

            <div class="auth-card">

                <h3>Verify your email</h3>

                <p class="intro">
                    We sent a verification link to your email address.
                </p>

                <p>
                    Please check your inbox and click the verification link
                    before signing in.
                </p>

                <a href="{{ route('login.show') }}" class="btn-gk full">
                    Back to Sign In
                </a>

            </div>

        </div>
    </section>

@endsection
