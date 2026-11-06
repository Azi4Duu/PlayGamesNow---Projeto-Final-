@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Categories',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Trashed Categories'
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
                            <h2>Trashed Categories</h2>
                            <p>Restore deleted game categories.</p>
                        </div>
                        <a class="btn-gk light" href="{{ route('admin.categories.index') }}">Back to categories</a>
                    </div>

                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.categories.trashed') }}">
                                <input type="text" name="search" placeholder="Search categories..." class="form-control-gk" value="{{ request('search') }}">
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <a href="{{ route('admin.categories.trashed') }}" class="btn-gk light">Clear Filters</a>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Deleted at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="icon-action" title="Restore"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <ul class="pagination">
                        @if($categories->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $categories->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $categories->lastPage(); $page++)
                            <li><a href="{{ $categories->url($page) }}" class="{{ $categories->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($categories->hasMorePages())
                            <li><a href="{{ $categories->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>
@endsection
