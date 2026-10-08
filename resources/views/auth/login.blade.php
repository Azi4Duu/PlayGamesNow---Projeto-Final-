@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Sign In',
        'breadcrumbs' => [
            [
            'label' => 'login'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="auth-section">
        <div class="container">
            @if($errors->any())
                <div class="auth-alert">
                    <div class="alert alert-danger">
                        <strong>Unable to log in.</strong>
                        <p>
                            @error('credentials')
                            {{$message}}
                            @enderror
                        </p>
                    </div>
                </div>
            @endif
            <div class="auth-card">
                <h3>Welcome back</h3>
                <p class="intro">Sign in to access your account and purchases.</p>
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                            class="form-control form-control-gk @error('email') is-invalid @enderror @error('credentials') is-invalid @enderror"
                            id="email"
                            name="email"
                            type="email"
                            placeholder="you@example.com"
                            value="{{old('email')}}"
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            class="form-control form-control-gk @error('password') is-invalid @enderror @error('credentials') is-invalid @enderror"
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Enter your password"
                        >
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button class="btn-gk full" type="submit">Sign In</button>
                </form>
                <div class="auth-links">
                    <a href="{{route('password.request')}}">Forgot password?</a>
                    <a href="{{route('register.show')}}">Create an account</a>
                </div>
                <div class="divider">or</div>
                <a href="{{ route('google.login') }}" class="btn-gk light full"><i class="fa-brands fa-google"></i>Google</a>
            </div>
        </div>
    </section>
@endsection
