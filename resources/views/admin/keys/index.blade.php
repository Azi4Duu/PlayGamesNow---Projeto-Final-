@extends('layout.main')

@section('content')
    @include('layout.parts.page-heading', [
        'title' => 'Game Keys',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Game Keys'
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
                            <h2>Game keys</h2>
                            <p>Manage digital key stock.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{route('admin.keys.create')}}">+ Add key</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form action="{{ route('admin.keys.index') }}" method="GET">
                                <select name="game" class="form-select-gk">
                                    <option value="">All games</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}" @selected(request('game') == $game->id)>{{ $game->title }}</option>
                                    @endforeach
                                </select>
                                <select name="status" class="form-select-gk">
                                    <option value="">All statuses</option>
                                    <option value="available" @selected(request('status') === 'available')>Available</option>
                                    <option value="reserved" @selected(request('status') === 'reserved')>Reserved</option>
                                    <option value="sold" @selected(request('status') === 'sold')>Sold</option>
                                    <option value="revoked" @selected(request('status') === 'revoked')>Revoked</option>
                                </select>
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <a href="{{ route('admin.keys.index') }}" class="btn-gk light">Clear Filters</a>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Game</th>
                                    <th>Platform</th>
                                    <th>Key</th>
                                    <th>Status</th>
                                    <th>Sold at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($keys as $key)
                                    <tr>
                                        <td>{{$key->gamePlatform->game->title}}</td>
                                        <td>{{$key->gamePlatform->platform->platform_name}}</td>
                                        <td><code>{{$key->code}}</code></td>
                                        <td><span class="status status-{{ $key->status }}">{{ ucfirst($key->status) }}</span></td>
                                        <td>{{ $key->sold_at ?? '-' }}</td>
                                        <td>
                                            <div class="actions">
                                                @if($key->status == 'available' || $key->status == 'revoked')
                                                    <a href="{{ route('admin.keys.edit', $key) }}" class="icon-action"><i class="fa fa-pen"></i></a>
                                                    @if($key->status == 'available')
                                                        <button type="submit" class="icon-action" data-bs-toggle="modal" data-bs-target="#deleteKeyModal{{ $key->id }}"><i class="fa fa-trash"></i></button>
                                                    @endif
                                                @else
                                                    <span class="text-muted">
                                                        No actions available
                                                    </span>
                                                @endif
                                            </div>
                                            @if($key->status == 'available')
                                                <div class="modal fade" id="deleteKeyModal{{ $key->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete game key</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to permanently delete this game key?</p>
                                                                <p class="mb-1">
                                                                    <strong>{{ $key->gamePlatform->game->title }} - {{ $key->gamePlatform->platform->platform_name }}</strong>
                                                                </p>
                                                                <code>{{ $key->code }}</code>
                                                                <p class="text-danger mt-3 mb-0">This action cannot be undone.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('admin.keys.destroy', $key) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Delete key</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <ul class="pagination">
                        @if($keys->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $keys->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $keys->lastPage(); $page++)
                            <li><a href="{{ $keys->url($page) }}" class="{{ $keys->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($keys->hasMorePages())
                            <li><a href="{{ $keys->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>
@endsection
