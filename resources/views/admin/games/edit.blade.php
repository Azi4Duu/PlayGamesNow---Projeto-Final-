@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Games',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Edit Game'
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
                            <h2>Edit game</h2>
                            <p>Edit an existing catalogue entry.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{route('admin.games.update', $game)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Title</label>
                                <input name="title" id="title" class="form-control form-control-gk @error('title') is-invalid @enderror" value="{{old('title', $game->title)}}">
                                @error('title')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-row-gk">
                                <div class="form-group">
                                    <label>Publisher</label>
                                    <select name="publisher_id" class="form-select-gk @error('publisher_id') is-invalid @enderror">
                                        @foreach($publishers as $publisher)
                                            <option value="{{$publisher->id}}" @selected(old('publisher_id', $game->publisher_id) == $publisher->id)>{{$publisher->publisher_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('publisher_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Release date</label>
                                    <input name="release_date" type="date" class="form-control form-control-gk @error('release_date') is-invalid @enderror" value="{{old('release_date', $game->release_date)}}">
                                    @error('release_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Image URL</label>
                                <input name="image_url" class="form-control form-control-gk @error('image_url') is-invalid @enderror" placeholder="https://..." value="{{old('image_url', $game->image_url)}}">
                                @error('image_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control form-control-gk @error('description') is-invalid @enderror">{{old('description', $game->description)}}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Categories</label>
                                <div class="category-options">
                                    @foreach ($categories as $category)
                                        <label>
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                @checked(in_array($category->id,old('categories',$game->categories->pluck('id')->toArray())))
                                            >
                                            {{ $category->category_name }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('categories')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Platforms & Prices</label>
                                @foreach ($platforms as $platform)
                                    @php
                                        $gamePlatform = $game->gamePlatforms->firstWhere('platform_id', $platform->id);
                                    @endphp
                                    <div class="platform-price-row">
                                        <div class="platform-check">
                                            <input
                                                type="checkbox"
                                                name="platforms[{{ $platform->id }}][selected]"
                                                value="1"
                                                id="platform_{{ $platform->id }}"
                                                @checked(old("platforms.{$platform->id}.selected", $gamePlatform ? 1 : 0))
                                            >
                                            <label for="platform_{{ $platform->id }}">
                                                {{ $platform->platform_name }}
                                            </label>
                                        </div>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="platforms[{{ $platform->id }}][price]"
                                            value="{{old("platforms.{$platform->id}.price",$gamePlatform?->price)}}"
                                            class="form-control-gk"
                                            placeholder="Price"
                                        >
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="platforms[{{ $platform->id }}][old_price]"
                                            value="{{ old("platforms.{$platform->id}.old_price",$gamePlatform?->old_price) }}"
                                            class="form-control-gk"
                                            placeholder="Old price"
                                        >
                                    </div>
                                @endforeach
                                @error('platforms')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-gk">Save game</button>
                            <a class="btn-gk light" href="{{route('admin.games.index')}}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
