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
                <form action="{{ route('games.shop') }}" method="GET" class="shop-filters">
                    <div class="shop-filter-row">
                        <div class="form-group">
                            <label>Search game</label>
                            <input type="text" name="search" class="form-control-gk" placeholder="Search by game name...">
                        </div>
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
                            <button type="submit" class="btn-gk light">
                                <i class="fa-solid fa-magnifying-glass"></i>
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
                </form>

            <div class="row trending-box">
                @foreach($gamePlatforms as $gamePlatform)
                    @php
                        $game = $gamePlatform->game;
                    @endphp
                    <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="{{route('games.show', $gamePlatform)}}"><img
                                        src="{{ $game->image_url ? $game->image_url : asset('assets/images/default-game.png') }}"
                                        alt="">
                                </a>
                                @if($gamePlatform->platform->icon_path)
                                    <span class="platform-icon">
                                        <img src="{{ asset($gamePlatform->platform->icon_path) }}" alt="{{ $gamePlatform->platform->platform_name }}">
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
                        <li><a href="#"> &lt; </a></li>
                        <li><a href="#">1</a></li>
                        <li><a class="is_active" href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"> &gt; </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
