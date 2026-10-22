@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Our Shop',
        'breadcrumbs' => [
            [
                'label' => 'Shop',
                'route' => route('games.shop'),
            ],
            [
                'label' => $gamePlatform->game->title
            ]
        ]
    ])

    @php
        $game = $gamePlatform->game;
    @endphp

    <div class="single-product section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
                        <img src="{{ $game->display_image }}" alt="{{ $game->title }}">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <h4>{{$game->title}}</h4>
                    <p>{{ $gamePlatform->platform->platform_name }}</p>
                    <span class="price">
                        @if($gamePlatform->old_price)
                            <em>{{number_format($gamePlatform->old_price, 2)}}€</em>
                        @endif
                        {{ number_format($gamePlatform->price, 2) }}€
                    </span>
                    <p></p>
                    @if($remainingStock > 0)
                        @auth
                            @role('customer')
                                <form action="{{route('customer.cart.store', $gamePlatform)}}" method="POST">
                                    @csrf
                                    <input type="number" class="form-control" name="quantity" value="1" min="1" max="{{$remainingStock}}">
                                    <button type="submit"><i class="fa fa-shopping-bag"></i> ADD TO CART</button>
                                </form>
                            @endrole
                        @endauth
                        @guest<a href="{{route('login.show')}}" class="btn-gk">Sign in to buy</a>@endguest
                    @else
                        <span class="status status-revoked">Out of stock</span>
                    @endif
                    <ul>
                        <li><span>Publisher:</span>{{$game->publisher->publisher_name}}</li>
                        <li><span>Platform:</span>{{$gamePlatform->platform->platform_name}}</li>
                        <li><span>Release date:</span>{{$game->release_date}}</li>
                        <li>
                            <span>Categories:</span>
                            @foreach($game->categories as $category)
                                {{ $category->category_name }}
                                @if(!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="sep"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="more-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-content">
                        <div class="row">
                            <div class="nav-wrapper ">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                                    </li>
                                    <!--<li class="nav-item" role="presentation">
                                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews (3)</button>
                                    </li>-->
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                    <p class="game-description">{{$game->description}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedGames->count())
        <div class="section trending related-games">
            <div class="container">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>Related Games</h2>
                        </div>
                    </div>

                </div>

                <div class="row related-games-row">
                    @foreach($relatedGames as $related)
                        <div class="related-game-col">
                            <div class="item">
                                <div class="thumb">
                                    <a href="{{ route('games.show', $related) }}">
                                        <img src="{{ $related->game->display_image }}" alt="{{ $related->game->title }}">
                                    </a>
                                    @if($related->platform->icon_path)
                                        <span class="platform-icon">
                                            <img src="{{ asset('storage/' . $related->platform->icon_path) }}" alt="{{ $related->platform->platform_name }}">
                                        </span>
                                    @endif
                                    <span class="price">
                                        @if($related->old_price)
                                            <em>{{ number_format($related->old_price, 2) }}€</em>
                                        @endif
                                        {{ number_format($related->price, 2) }}€
                                    </span>
                                </div>
                                <div class="down-content">
                                    @foreach($related->game->categories as $category)
                                        <span class="category">
                                            {{ $category->category_name }}
                                        </span>
                                    @endforeach
                                    <h4>{{ $related->game->title }}</h4>
                                    <a href="{{ route('games.show', $related) }}"><i class="fa fa-shopping-bag"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
