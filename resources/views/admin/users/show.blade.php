@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'User Details',
        'breadcrumbs' => [
            [
                'label' => 'Admin / User Details'
            ]
        ]
    ])

    <section class="admin-section">
        <div class="container">
            <div class="admin-shell">
                @include('layout.parts.admin-sidebar')
                <main class="admin-main">
                    <div class="admin-top">
                        <div>
                            <h2>{{$user->name}}</h2>
                            <p>Registered user details.</p>
                        </div>
                        <a class="btn-gk" href="{{route('admin.users.edit', $user)}}">Edit user</a>
                    </div>
                    <div class="admin-card">
                        <div class="data-list">
                            <div class="data-item">
                                <span>Email</span>
                                <strong>{{$user->email}}</strong>
                            </div>
                            <div class="data-item">
                                <span>Username</span>
                                <strong>{{$user->username}}</strong>
                            </div>
                            <div class="data-item">
                                <span>Role</span>
                                <strong>{{$user->role}}</strong>
                            </div>
                            <div class="data-item">
                                <span>Status</span>
                                <strong>{{$user->active ? 'Active' : 'Inactive'}}</strong>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
