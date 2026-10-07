@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Trashed Users',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Trashed Users'
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
                            <h2>Trashed Users</h2>
                            <p>Manage trashed users.</p>
                        </div>
                        <div>
                            <a class="btn-gk light" href="{{route('admin.users.index')}}">Cancel</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <!--<div class="admin-filter">
                            <input class="form-control-gk" placeholder="Search users...">
                            <select class="form-select-gk">
                                <option>All roles</option>
                                @foreach($roles as $role)
                                    <option>{{ucfirst($role)}}</option>
                                @endforeach
                            </select>
                            <a class="btn-gk light" href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                        </div>-->
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{ucfirst($user->role)}}</td>
                                        <td><span class="status {{ $user->active ? 'active' : 'inactive' }}">{{ $user->active ? 'Active' : 'Inactive' }}</span></td>
                                        <td class="actions">
                                            <form action="{{route('admin.users.restore', $user->id)}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('PUT')
                                                <button class="icon-action" type="submit"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
