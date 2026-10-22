@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Platforms',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Platforms'
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
                            <h2>Platforms</h2>
                            <p>Manage game platforms.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{ route('admin.platforms.create') }}">+ Add platform</a>
                            <a class="btn-gk light" href="{{ route('admin.platforms.trashed') }}"><i class="fa-solid fa-trash"></i>Show Trashed</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.platforms.index') }}">
                                <input type="text" name="search" placeholder="Search platforms..." class="form-control-gk">
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Platform</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($platforms as $platform)
                                    <tr>
                                        <td>
                                            @if($platform->icon_path)
                                                <span class="admin-platform-icon">
                                                    <img src="{{ asset('storage/' . $platform->icon_path) }}" alt="{{ $platform->platform_name }}">
                                                </span>
                                            @else
                                                <span class="admin-platform-icon">
                                                    <i class="fa-solid fa-gamepad"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $platform->platform_name }}</td>
                                        <td>
                                            <div class="actions">
                                                <a class="icon-action" href="{{ route('admin.platforms.edit', $platform) }}"><i class="fa fa-pen"></i></a>
                                                <button type="button" class="icon-action" data-bs-toggle="modal" data-bs-target="#deletePlatformModal{{ $platform->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="modal fade" id="deletePlatformModal{{ $platform->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete platform</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete<strong> {{ $platform->platform_name }}</strong>?</p>
                                                            <p class="text-muted mb-0">
                                                                You can restore this platform later.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.platforms.destroy', $platform) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete platform</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <ul class="pagination">
                        @if($platforms->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $platforms->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $platforms->lastPage(); $page++)
                            <li><a href="{{ $platforms->url($page) }}" class="{{ $platforms->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($platforms->hasMorePages())
                            <li><a href="{{ $platforms->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>

@endsection
