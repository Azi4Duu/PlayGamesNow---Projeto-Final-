@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Games',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Add Game'
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
                            <h2>Add game</h2>
                            <p>Create a new catalogue entry.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{route('admin.games.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input name="title" id="title" class="form-control form-control-gk @error('title') is-invalid @enderror" placeholder="Game title" value="{{ old('title') }}" >
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
                                        <option value="">Select publisher</option>
                                        @foreach($publishers as $publisher)
                                            <option value="{{$publisher->id}}" @selected(old('publisher_id') == $publisher->id)>{{$publisher->publisher_name}}</option>
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
                                    <input name="release_date" type="date" class="form-control form-control-gk @error('release_date') is-invalid @enderror" value="{{ old('release_date') }}">
                                    @error('release_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Image URL</label>
                                <input name="image_url" class="form-control form-control-gk @error('image_url') is-invalid @enderror" placeholder="https://..." value="{{ old('image_url') }}">
                                @error('image_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control form-control-gk @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
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
                                                @checked(in_array($category->id, old('categories', [])))
                                            >
                                            {{ $category->category_name }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('categories')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Platforms & Prices</label>
                                @foreach ($platforms as $platform)
                                    <div class="platform-price-row">
                                        <div class="platform-check">
                                            <input type="checkbox" name="platforms[{{ $platform->id }}][selected]" value="1" id="platform_{{ $platform->id }}"
                                                @checked(old("platforms.{$platform->id}.selected"))
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
                                            value="{{ old("platforms.{$platform->id}.price") }}"
                                            class="form-control-gk"
                                            placeholder="Price"
                                        >
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="platforms[{{ $platform->id }}][old_price]"
                                            value="{{ old("platforms.{$platform->id}.old_price") }}"
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
