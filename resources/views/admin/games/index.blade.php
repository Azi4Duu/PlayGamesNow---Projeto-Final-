@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Games',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Games'
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
                            <h2>Games</h2>
                            <p>Manage the game catalogue.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{route('admin.games.create')}}">+ Add game</a>
                            <a class="btn-gk light" href="{{route('admin.games.trashed')}}"><i class="fa-solid fa-trash"></i>Show Trashed</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form action="{{route('admin.games.index')}}" method="GET">
                                <input type="text" name="search" value="{{request('search')}}" class="form-control-gk" placeholder="Search games...">
                                <select name="publisher" class="form-select-gk">
                                    <option value="">All publishers</option>
                                    @foreach ($publishers as $publisher)
                                        <option value="{{ $publisher->id }}"@selected(request('publisher') == $publisher->id)>
                                            {{ $publisher->publisher_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="category" class="form-select-gk">
                                    <option value="">All categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"@selected(request('category') == $category->id)>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="platform" class="form-select-gk">
                                    <option value="">All platforms</option>
                                    @foreach ($platforms as $platform)
                                        <option value="{{ $platform->id }}"@selected(request('platform') == $platform->id)>
                                            {{ $platform->platform_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Game</th>
                                    <th>Platform/Price</th>
                                    <th>Publisher</th>
                                    <th>Release</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($games as $game)


                                    <tr>
                                        <td>
                                            <div class="product-mini">
                                                @if($game->display_image)
                                                    <img src="{{$game->display_image}}" alt="{{$game->title}}" width="55" height="70">
                                                @else
                                                    <i class="fa fa-gamepad"></i>
                                                @endif
                                                <strong>{{$game->title}}</strong>
                                            </div>
                                            <div class="game-categories">
                                                @foreach ($game->categories as $category)
                                                    <span>{{ $category->category_name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @foreach ($game->gamePlatforms as $gamePlatform)
                                                <div>
                                                    {{ $gamePlatform->platform->platform_name }}-{{ number_format($gamePlatform->price, 2, ',', '.') }} €
                                                    @if ($gamePlatform->old_price)
                                                        <del>
                                                            {{ number_format($gamePlatform->old_price, 2, ',', '.') }}€
                                                        </del>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{$game->publisher->publisher_name}}</td>
                                        <td>{{$game->release_date}}</td>
                                        <td>
                                            <div class="actions">
                                                <a class="icon-action" href="{{route('admin.games.edit', $game)}}"><i class="fa fa-pen"></i></a>
                                                <button type="submit" class="icon-action" data-bs-toggle="modal" data-bs-target="#deleteGameModal{{ $game->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="modal fade" id="deleteGameModal{{ $game->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete game</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete <strong>{{ $game->title }}</strong>?</p>
                                                            <p class="text-muted mb-0">You can restore this game later.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete game</button>
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
                        @if($games->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $games->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $games->lastPage(); $page++)
                            <li><a href="{{ $games->url($page) }}" class="{{ $games->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($games->hasMorePages())
                            <li><a href="{{ $games->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>
@endsection
