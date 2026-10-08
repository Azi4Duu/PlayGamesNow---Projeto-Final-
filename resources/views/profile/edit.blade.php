@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'My Profile',
        'breadcrumbs' => [
            [
                'label' => 'Profile / Edit'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="profile-section">
        <div class="container">
            @if($errors->any())
                <div class="auth-alert">
                    <div class="alert alert-danger">
                        <strong>Something went wrong</strong>
                    </div>
                </div>
            @endif
            <div class="content-card">
                <h3>Edit profile</h3>
                <p class="intro">Update your personal information.</p>
                <form action="{{route('customer.profile.edit')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-row-gk">
                        <div class="form-group">
                            <label>Full name</label>
                            <input class="form-control form-control-gk @error('name') is-invalid @enderror" name="name" value="{{old('name', $user->name)}}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control form-control-gk @error('username') is-invalid @enderror" name="username" value="{{old('username', $user->username)}}">
                            @error('username')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control form-control-gk @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email', $user->email)}}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-gk">Save changes</button>
                    <a class="btn-gk light" href="{{route('customer.profile.show')}}">Cancel</a>
                </form>
            </div>
        </div>
    </section>
@endsection
