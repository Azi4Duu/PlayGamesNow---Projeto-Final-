@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Platforms',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Add Platform'
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
                            <h2>Add platform</h2>
                            <p>Create a new game platform.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.platforms.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Platform name</label>
                                <input type="text" name="platform_name" class="form-control form-control-gk @error('platform_name') is-invalid @enderror" placeholder="Platform name" value="{{ old('platform_name') }}">
                                @error('platform_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Icon path</label>
                                <input type="text" name="icon_path" class="form-control form-control-gk @error('icon_path') is-invalid @enderror" placeholder="assets/images/platforms/steam.png" value="{{ old('icon_path') }}">
                                @error('icon_path')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-gk">Save platform</button>
                            <a class="btn-gk light" href="{{ route('admin.platforms.index') }}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
