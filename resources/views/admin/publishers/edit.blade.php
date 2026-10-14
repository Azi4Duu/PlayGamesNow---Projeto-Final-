@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Publishers',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Edit Publisher'
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
                            <h2>Edit publisher</h2>
                            <p>Update publisher information.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.publishers.update', $publisher) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Publisher name</label>
                                <input type="text" name="publisher_name" class="form-control form-control-gk @error('publisher_name') is-invalid @enderror" value="{{ old('publisher_name', $publisher->publisher_name) }}">
                                @error('publisher_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" name="website" class="form-control form-control-gk @error('website') is-invalid @enderror" value="{{ old('website', $publisher->website) }}">
                                @error('website')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control form-control-gk @error('country') is-invalid @enderror" value="{{ old('country', $publisher->country) }}">
                                @error('country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-gk">
                                Update publisher
                            </button>
                            <a class="btn-gk light" href="{{ route('admin.publishers.index') }}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
