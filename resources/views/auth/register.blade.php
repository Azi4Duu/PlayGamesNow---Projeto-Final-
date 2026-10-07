@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Create Account',
        'breadcrumbs' => [
            [
            'label' => 'Register'
            ]
        ]
    ])

    <section class="auth-section">
        <div class="container">
            @if($errors->any())
                <div class="auth-alert">
                    <div class="alert alert-danger">
                        <strong>Unable to create account.</strong>
                        <p>
                            @error('credentials')
                            {{$message}}
                            @enderror
                        </p>
                    </div>
                </div>
            @endif
            <div class="auth-card">
                <h3>Create your account</h3>
                <p class="intro">Register to buy and manage your game keys.</p>
                <form action="{{route('register')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input class="form-control form-control-gk @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Your full name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control form-control-gk @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="Choose a username">
                        @error('username')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control form-control-gk @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control form-control-gk @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Minimum 6 characters">
                        @error('password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm password</label>
                        <input class="form-control form-control-gk @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" type="password" placeholder="Repeat your password">
                        @error('confirm_password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <button class="btn-gk full" type="submit">Create Account</button>
                </form>
                <div class="auth-links">
                    <span>Already have an account?</span>
                    <a href="{{route('login.show')}}">Sign in</a>
                </div>
            </div>
        </div>
    </section>
@endsection
