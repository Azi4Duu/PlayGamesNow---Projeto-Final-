@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Users',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Users'
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
                            <h2>Users</h2>
                            <p>Manage registered users.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{route('admin.users.create')}}">+ Add user</a>
                            <a class="btn-gk light" href="{{route('admin.users.trashed')}}"><i class="fa-solid fa-trash"></i>Show Trashed</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{route('admin.users.index')}}" method="GET">
                            @csrf
                            <div class="admin-filter">
                                <input class="form-control-gk" placeholder="Search users..." id="search" name="search">
                                <select class="form-select-gk" id="role" name="role">
                                    <option value="">All roles</option>
                                    @foreach($roles as $role)
                                        <option>{{ucfirst($role->name)}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
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
                                @if(!request('search') && !request('role'))
                                    <tr>
                                        <td>{{$userauth->name}}</td>
                                        <td>{{$userauth->email}}</td>
                                        <td>{{ucfirst($userauth->role)}}</td>
                                        <td><span class="status {{ $userauth->active ? 'active' : 'inactive' }}">{{ $userauth->active ? 'Active' : 'Inactive' }}</span></td>
                                        <td>
                                            <div class="actions">
                                                <a class="icon-action" href="{{route('admin.users.show', $userauth)}}"><i class="fa fa-eye"></i></a>
                                                <a class="icon-action" href="{{route('admin.users.edit', $userauth)}}"><i class="fa fa-pen"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{ucfirst($user->role)}}</td>
                                        <td><span class="status {{ $user->active ? 'active' : 'inactive' }}">{{ $user->active ? 'Active' : 'Inactive' }}</span></td>
                                        <td class="actions">
                                            <a class="icon-action" href="{{route('admin.users.show', $user)}}"><i class="fa fa-eye"></i></a>
                                            <a class="icon-action" href="{{route('admin.users.edit', $user)}}"><i class="fa fa-pen"></i></a>
                                            <form action="{{route('admin.users.destroy', $user)}}" method="POST" style="display: inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="icon-action" type="submit"><i class="fa fa-trash"></i></button>
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
