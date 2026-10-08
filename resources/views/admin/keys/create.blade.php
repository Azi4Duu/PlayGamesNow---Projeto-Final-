@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Add Game Key',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Add Game Key'
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
                            <h2>Add game key</h2>
                            <p>Add a new key to the available stock.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.keys.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Game / Platform</label>
                                <select name="game_platform_id" class="form-select-gk @error('game_platform_id') is-invalid @enderror">
                                    <option value="">
                                        Select game and platform
                                    </option>
                                    @foreach ($gamePlatforms as $gamePlatform)
                                        <option value="{{ $gamePlatform->id }}"@selected(old('game_platform_id') == $gamePlatform->id)>
                                            {{ $gamePlatform->game->title }}-{{ $gamePlatform->platform->platform_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('game_platform_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Game Key</label>
                                <input type="text" name="code" value="{{ old('code') }}" class="form-control form-control-gk @error('code') is-invalid @enderror" placeholder="XXXXX-XXXXX-XXXXX">
                                @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-gk">Save key</button>
                            <a href="{{ route('admin.keys.index') }}" class="btn-gk light">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
