@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'My Profile',
        'breadcrumbs' => [
            [
                'label' => 'Profile / Password'
            ]
        ]
    ])

    <section class="auth-section">
        <div class="container">
            @if($errors->any())
                <div class="auth-alert">
                    <div class="alert alert-danger">
                        <strong>Something went wrong</strong>
                    </div>
                </div>
            @endif
            <div class="auth-card">
                <h3>Change password</h3>
                <p class="intro">For security, enter your current password before choosing a new one.</p>
                <form action="{{route('customer.profile.change-password')}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="current_password">Current password</label>
                        <input class="form-control form-control-gk @error('current_password') is-invalid @enderror" id="current_password" name="current_password" type="password" placeholder="Current password">
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_password">New password</label>
                        <input class="form-control form-control-gk @error('new_password') is-invalid @enderror" id="new_password" name="new_password" type="password" placeholder="New password">
                        @error('new_password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm new password</label>
                        <input class="form-control form-control-gk @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" type="password" placeholder="Repeat new password">
                        @error('confirm_password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <button class="btn-gk full" type="submit">Update Password</button>
                    <a class="btn-gk full light" href="{{route('customer.profile.show')}}">Cancel</a>
                </form>
            </div>
        </div>
    </section>
@endsection
