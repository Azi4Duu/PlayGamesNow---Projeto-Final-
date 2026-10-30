@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Edit User',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Edit User'
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
                            <h2>Edit user</h2>
                            <p>Update account details.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{route('admin.users.update', $user)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row-gk">
                                <div class="form-group">
                                    <label>Full name</label>
                                    <input class="form-control form-control-gk @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control form-control-gk @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username', $user->username)}}">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control form-control-gk @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $user->email)}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            @if($userauth->id != $user->id)
                                <div class="form-row-gk">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control form-select-gk @error('role') is-invalid @enderror" id="role" name="role">
                                            @foreach($roles as $role)
                                                <option value="{{$role->name}}" @if($user->role == $role->name) selected @endif>
                                                    {{ucfirst($role->name)}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control form-select-gk @error('active') is-invalid @enderror" id="active" name="active">
                                            <option value="1" @if($user->active == 1) selected @endif>Active</option>
                                            <option value="0" @if($user->active == 0) selected @endif>Inactive</option>
                                        </select>
                                        @error('active')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if($userauth->id == $user->id)
                                <div class="form-row-gk">
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control form-control-gk @error('password') is-invalid @enderror" id="password" name="password">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control form-control-gk" id="password_confirmation" name="password_confirmation">
                                    </div>
                                </div>
                            @endif
                            <button class="btn-gk" type="submit">Save user</button>
                            <a class="btn-gk light" href="{{route('admin.users.index')}}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
