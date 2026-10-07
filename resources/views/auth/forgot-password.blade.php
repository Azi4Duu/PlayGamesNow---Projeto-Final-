@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Forgot password',
        'breadcrumbs' => [
            ['label' => 'Forgot password']
        ]
    ])

    <section class="auth-section">
        <div class="container">
            <div class="auth-card">
                <h3>Recover your password</h3>
                <p class="intro">Enter your email and we will send a password reset link.</p>
                <form action="{{route('password.email')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form control form-control-gk @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            @error('email')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button class="btn-gk full" type="submit">Send Reset Link</button>
                </form>
                <div class="auth-links">
                    <a href="{{route('login.show')}}">Back to sign in</a>
                </div>
            </div>
        </div>
    </section>
@endsection
