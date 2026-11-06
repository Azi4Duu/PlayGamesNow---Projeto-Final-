@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Trashed Games',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Trashed Games'
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
                            <h2>Trashed Games</h2>
                            <p>Manage trashed Games.</p>
                        </div>
                        <div>
                            <a class="btn-gk light" href="{{route('admin.games.index')}}">Back to games</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form action="{{route('admin.games.trashed')}}" method="GET">
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
                                <a href="{{ route('admin.games.trashed') }}" class="btn-gk light">Clear Filters</a>
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
                                                <form action="{{route('admin.games.restore', $game->id)}}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="icon-action"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                                </form>
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
