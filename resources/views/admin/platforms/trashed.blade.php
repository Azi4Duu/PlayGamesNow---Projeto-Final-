@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Platforms',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Trashed Platforms'
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
                            <h2>Trashed Platforms</h2>
                            <p>Restore deleted game platforms.</p>
                        </div>
                        <a class="btn-gk light" href="{{ route('admin.platforms.index') }}">Back to platforms</a>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.platforms.trashed') }}">
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
                                    <th>Deleted at</th>
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
                                        <td>{{ $platform->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.platforms.restore', $platform->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="icon-action" title="Restore"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                            </form>
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
