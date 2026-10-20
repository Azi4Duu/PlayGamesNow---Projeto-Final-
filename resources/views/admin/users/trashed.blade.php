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

    @include('layout.parts.flash-messages')

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
                            <a class="btn-gk light" href="{{route('admin.users.index')}}">Back to users</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{route('admin.users.trashed')}}" method="GET">
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
                                            <form action="{{route('admin.users.restore', $user->id)}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="icon-action" type="submit"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                            </form>
                                        </td>
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
