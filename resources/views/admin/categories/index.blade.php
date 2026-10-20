@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Categories',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Categories'
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
                            <h2>Categories</h2>
                            <p>Manage game categories.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{ route('admin.categories.create') }}">+ Add category</a>
                            <a class="btn-gk light" href="{{ route('admin.categories.trashed') }}"><i class="fa-solid fa-trash"></i>Show Trashed</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.categories.index') }}">
                                <input type="text" name="search" placeholder="Search categories..." class="form-control-gk">
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ ucfirst($category->category_name) }}</td>
                                        <td>
                                            <div class="actions">
                                                <a class="icon-action" href="{{ route('admin.categories.edit', $category) }}"><i class="fa fa-pen"></i></a>
                                                <button type="button" class="icon-action" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete category</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete<strong> {{ $category->category_name }}</strong>?</p>
                                                            <p class="text-muted mb-0">You can restore this category later.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete category</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
