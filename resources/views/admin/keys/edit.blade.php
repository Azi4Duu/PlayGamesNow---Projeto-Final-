@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Edit Game Key',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Edit Game Key'
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
                            <h2>Edit game key</h2>
                            <p>Update an existing game key.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.keys.update', $key) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Game / Platform</label>
                                <select name="game_platform_id" class="form-select-gk @error('game_platform_id') is-invalid @enderror">
                                    <option value="">
                                        Select game and platform
                                    </option>
                                    @foreach ($gamePlatforms as $gamePlatform)
                                        <option value="{{ $gamePlatform->id }}"
                                            @selected(old('game_platform_id',$key->game_platform_id) == $gamePlatform->id)>
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
                                <input type="text" name="code" value="{{ old('code', $key->code) }}" class="form-control form-control-gk @error('code') is-invalid @enderror" placeholder="XXXXX-XXXXX-XXXXX">
                                @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if($key->status == 'available' || $key->status == 'revoked')
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-select-gk @error('status') is-invalid @enderror">
                                        <option value="available"@selected(old('status', $key->status) == 'available')>
                                            Available
                                        </option>
                                        <option value="revoked"@selected(old('status', $key->status) == 'revoked')>
                                            Revoked
                                        </option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            @endif
                            <button type="submit" class="btn-gk">Save changes</button>
                            <a href="{{ route('admin.keys.index') }}" class="btn-gk light">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
