@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Add User',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Add User'
            ]
        ]
    ])

    <section class="admin-section">
        <div class="container">
            @if($errors->any())
                <div class="auth-alert">
                    <div class="alert alert-danger">
                        <strong>Unable to create account.</strong>
                    </div>
                </div>
            @endif
            <div class="admin-shell">
                @include('layout.parts.admin-sidebar')
                <main class="admin-main">
                    <div class="admin-top">
                        <div>
                            <h2>Add user</h2>
                            <p>Create a new customer or administrator.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{route('admin.users.store')}}" method="POST">
                            @csrf
                            <div class="form-row-gk">
                                <div class="form-group">
                                    <label>Full name</label>
                                    <input class="form-control form-control-gk @error('name') is-invalid @enderror" id="name" name="name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control form-control-gk @error('username') is-invalid @enderror" id="username" name="username">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control form-control-gk @error('email') is-invalid @enderror" id="email" name="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-row-gk">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control form-select-gk @error('role') is-invalid @enderror" id="role" name="role">
                                        @foreach($roles as $role)
                                            <option value="{{$role->name}}">{{ucfirst($role->name)}}</option>
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
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('active')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control form-control-gk @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <button class="btn-gk" type="submit">Save user</button>
                            <a class="btn-gk light" href="{{route('admin.users.index')}}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
