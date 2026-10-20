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

    @include('layout.parts.flash-messages')

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
                                <select class="form-select-gk" name="active">
                                    <option value="">All Status</option>
                                    <option value="1"{{ request('active') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0"{{ request('active') === '0' ? 'selected' : '' }}>Inactive</option>
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
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{ucfirst($user->role)}}</td>
                                        <td><span class="status {{ $user->active ? 'active' : 'inactive' }}">{{ $user->active ? 'Active' : 'Inactive' }}</span></td>
                                        <td class="actions">
                                            <a class="icon-action" href="{{route('admin.users.show', $user)}}"><i class="fa fa-eye"></i></a>
                                            <a class="icon-action" href="{{route('admin.users.edit', $user)}}"><i class="fa fa-pen"></i></a>
                                            @if($user->id !== auth()->id())
                                                <button class="icon-action" type="submit" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete user</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete <strong>{{ $user->name}}</strong>?</p>
                                                        <p class="text-muted mb-0">You can restore this user later.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete user</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="pagination">
                                @if($users->onFirstPage())
                                    <li><a class="disabled">&lt;</a></li>
                                @else
                                    <li><a href="{{ $users->previousPageUrl() }}">&lt;</a></li>
                                @endif
                                @for($page = 1; $page <= $users->lastPage(); $page++)
                                    <li><a href="{{ $users->url($page) }}" class="{{ $users->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                                @endfor
                                @if($users->hasMorePages())
                                    <li><a href="{{ $users->nextPageUrl() }}">&gt;</a></li>
                                @else
                                    <li><a class="disabled">&gt;</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
