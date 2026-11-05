@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Our Shop',
        'breadcrumbs' => [
            [
            'label' => 'Our Shop'
            ]
        ]
    ])

    <div class="section trending">
        <div class="container">
            <form action="{{ route('games.shop') }}" method="GET">
                <div class="shop-search-row">
                    <div class="search-group">
                        <label>Search game</label>
                        <input type="text" name="search" class="form-control-gk" placeholder="Search by game name...">
                    </div>
                    <div class="search-actions">
                        <button type="submit" class="btn-gk light">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button class="btn-gk light" type="button" data-bs-toggle="collapse" data-bs-target="#shopFilters" aria-expanded="false" aria-controls="shopFilters">
                            <i class="fa-solid fa-filter"></i>
                            Filters
                        </button>
                    </div>
                </div>
                <div class="collapse" id="shopFilters">
                    <div class="shop-filters">
                        <div class="shop-filter-row">
                            <div class="form-group">
                                <label>Platform</label>
                                <select name="platform" class="form-select-gk">
                                    <option value="">All platforms</option>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}">
                                            {{ $platform->platform_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Order by price</label>
                                <select name="order" class="form-select-gk">
                                    <option value="">Default</option>
                                    <option value="asc">Price: Low to High</option>
                                    <option value="desc">Price: High to Low</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stock" class="form-label">Stock</label>
                                <select name="stock" id="stock" class="form-select-gk">
                                    <option value="">All</option>
                                    <option value="in">In Stock</option>
                                    <option value="out">Out of Stock</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-gk light">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Categories</label>
                            <div class="category-options">
                                @foreach($categories as $category)
                                    <label>
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                                        {{ $category->category_name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row trending-box">
                @foreach($gamePlatforms as $gamePlatform)
                    @php
                        $game = $gamePlatform->game;
                    @endphp
                    <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="{{route('games.show', $gamePlatform)}}">
                                    <img src="{{ $game->display_image }}" alt="{{ $game->title }}">
                                </a>
                                @if($gamePlatform->platform->icon_path)
                                    <span class="platform-icon">
                                        <img src="{{ asset('storage/' . $gamePlatform->platform->icon_path) }}" alt="{{ $gamePlatform->platform->platform_name }}">
                                    </span>
                                @endif
                                <span class="price">
                                    @if($gamePlatform->old_price)
                                        <em>{{number_format($gamePlatform->old_price, 2)}}€</em>
                                    @endif
                                    {{number_format($gamePlatform->price, 2)}}€
                                </span>
                            </div>
                            <div class="down-content">
                                @foreach($game->categories as $category)
                                    <span class="category">{{$category->category_name}}</span>
                                @endforeach
                                <h4>{{$game->title}}</h4>
                                <a href="{{route('games.show', $game)}}"><i class="fa fa-shopping-bag"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="pagination">
                        @if($gamePlatforms->onFirstPage())
                            <li><a class="disabled"> &lt; </a></li>
                        @else
                            <li><a href="{{ $gamePlatforms->previousPageUrl() }}"> &lt; </a></li>
                        @endif

                        @for($page = 1; $page <= $gamePlatforms->lastPage(); $page++)
                            <li><a href="{{ $gamePlatforms->url($page) }}" class="{{ $gamePlatforms->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor

                        @if($gamePlatforms->hasMorePages())
                            <li><a href="{{ $gamePlatforms->nextPageUrl() }}"> &gt; </a></li>
                        @else
                            <li><a class="disabled"> &gt; </a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
