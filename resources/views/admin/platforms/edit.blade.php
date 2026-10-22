@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Platforms',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Edit Platform'
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
                            <h2>Edit platform</h2>
                            <p>Update platform information.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.platforms.update', $platform) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Platform name</label>
                                <input type="text" name="platform_name" class="form-control form-control-gk @error('platform_name') is-invalid @enderror" value="{{ old('platform_name', $platform->platform_name) }}">
                                @error('platform_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Platform Icon</label>
                                <input type="file" name="icon" class="form-control form-control-gk file-input @error('icon') is-invalid @enderror" accept="image/*">
                                @error('icon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @if($platform->icon_path)
                                <div class="form-group">
                                    <label>Current icon</label>
                                    <div>
                                        <div>
                                            <span class="admin-platform-icon">
                                                <img src="{{ asset('storage/' . $platform->icon_path) }}" alt="{{ $platform->platform_name }}">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <button type="submit" class="btn-gk">Update platform</button>
                            <a class="btn-gk light" href="{{ route('admin.platforms.index') }}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
