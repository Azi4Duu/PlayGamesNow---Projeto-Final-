@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Categories',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Add Category'
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
                            <h2>Add category</h2>
                            <p>Create a new game category.</p>
                        </div>
                    </div>
                    <div class="admin-card">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Category name</label>
                                <input type="text" name="category_name" class="form-control form-control-gk @error('category_name') is-invalid @enderror" placeholder="Category name" value="{{ old('category_name') }}">
                                @error('category_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-gk">Save category</button>
                            <a class="btn-gk light" href="{{ route('admin.categories.index') }}">Cancel</a>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

@endsection
