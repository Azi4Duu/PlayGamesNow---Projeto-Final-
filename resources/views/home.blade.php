@extends('layout.main')

@section('content')
    <div class="main-banner">
        <div class="container">
            <div class="row">
                @include('layout.parts.flash-messages')
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>Welcome to Play Games Now</h6>
                        <h2>BEST GAMING SITE EVER!</h2>
                        <div class="search-input">
                            <form action="{{ route('games.shop') }}" method="GET">
                                <input type="text" placeholder="Search for a game..." name="search" value="{{ request('search') }}" />
                                <button type="submit">Search Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="right-image">
                        @if($featuredGame)
                            <a href="{{ route('games.show', $featuredGame) }}">
                                <img src="{{ $featuredGame->game->display_image }}" alt="{{ $featuredGame->game->title }}">
                                <span class="price">{{ number_format($featuredGame->price, 2, ',', '.') }}€</span>
                                <span class="offer">-{{ $featuredGame->discount_percentage }}%</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="container">
            <div class="row">
                @foreach($topPlatforms as $platform)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('games.shop', ['platform' => $platform->id]) }}">
                            <div class="item">
                                <div class="home-platform-icon">
                                    @if($platform->icon_path)
                                        <img src="{{ asset('storage/' . $platform->icon_path) }}" alt="{{ $platform->platform_name }}">
                                    @else
                                        <i class="fa fa-gamepad"></i>
                                    @endif
                                </div>
                                <h4>{{ $platform->platform_name }}</h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section trending">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>Trending</h6>
                        <h2>Trending Games</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="{{route('games.shop')}}">View All</a>
                    </div>
                </div>
                @foreach($trendingGames as $gamePlatform)
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="{{route('games.show', $gamePlatform)}}">
                                    <img src="{{ $gamePlatform->game->display_image }}" alt="{{ $gamePlatform->game->title }}">
                                </a>
                                <span class="price">
                                    @if($gamePlatform->old_price)
                                        <em>
                                            {{ number_format($gamePlatform->old_price, 2, ',', '.') }}€
                                        </em>
                                    @endif
                                    {{ number_format($gamePlatform->price, 2, ',', '.') }}€
                                </span>
                            </div>
                            <div class="down-content">
                                <span class="category">{{ $gamePlatform->platform->platform_name }}</span>
                                <h4>{{ $gamePlatform->game->title }}</h4>
                                <a href="{{ route('games.show', $gamePlatform) }}"><i class="fa fa-shopping-bag"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section most-played">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>TOP GAMES</h6>
                        <h2>Best Sellers</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="{{route('games.shop')}}">View All</a>
                    </div>
                </div>
                @foreach($bestSellers as $gamePlatform)
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="{{ route('games.show', $gamePlatform) }}">
                                    <img class="best-seller-image" src="{{ $gamePlatform->game->display_image }}" alt="{{ $gamePlatform->game->title }}">
                                </a>
                            </div>
                            <div class="down-content">
                                <span class="category">{{ $gamePlatform->platform->platform_name }}</span>
                                <h4>{{ $gamePlatform->game->title }}</h4>
                                <a href="{{ route('games.show', $gamePlatform) }}">Explore</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Categories</h6>
                        <h2>Top Categories</h2>
                    </div>
                </div>
                @foreach($topCategories as $category)
                    @php
                        $categoryGame = $category->games->first();
                    @endphp
                    <div class="col-lg col-sm-6 col-xs-12">
                        <div class="item">
                            <h4>{{ $category->category_name }}</h4>
                            <div class="thumb">
                                <a href="{{ route('games.shop', ['categories' => $category->id]) }}">
                                    @if($categoryGame)
                                        <img class="best-seller-image" src="{{ $categoryGame->display_image }}" alt="{{ $category->category_name }}">
                                    @else
                                        <img class="best-seller-image" src="{{ asset('assets/images/default-game.png') }}" alt="{{ $category->category_name }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
