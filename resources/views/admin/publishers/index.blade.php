@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Publishers',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Publishers'
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
                            <h2>Publishers</h2>
                            <p>Manage game publishers.</p>
                        </div>
                        <div>
                            <a class="btn-gk" href="{{ route('admin.publishers.create') }}">+ Add publisher</a>
                            <a class="btn-gk light" href="{{ route('admin.publishers.trashed') }}"><i class="fa-solid fa-trash"></i>Show Trashed</a>
                        </div>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.publishers.index') }}">
                                <input type="text" name="search" placeholder="Search publishers..." class="form-control-gk">
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Publisher</th>
                                    <th>Website</th>
                                    <th>Country</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($publishers as $publisher)
                                    <tr>
                                        <td>{{ $publisher->publisher_name }}</td>
                                        <td>{{ $publisher->website }}</td>
                                        <td>{{ $publisher->country }}</td>
                                        <td>
                                            <div class="actions">
                                                <a class="icon-action" href="{{ route('admin.publishers.edit', $publisher) }}"><i class="fa fa-pen"></i></a>
                                                <button type="button" class="icon-action" data-bs-toggle="modal" data-bs-target="#deletePublisherModal{{ $publisher->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="modal fade" id="deletePublisherModal{{ $publisher->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete publisher</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete<strong> {{ $publisher->publisher_name }}</strong>?</p>
                                                            <p class="text-muted mb-0">You can restore this publisher later.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete publisher</button>
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
                        @if($publishers->onFirstPage())
                            <li><a class="disabled">&lt;</a></li>
                        @else
                            <li><a href="{{ $publishers->previousPageUrl() }}">&lt;</a></li>
                        @endif
                        @for($page = 1; $page <= $publishers->lastPage(); $page++)
                            <li><a href="{{ $publishers->url($page) }}" class="{{ $publishers->currentPage() == $page ? 'is_active' : '' }}">{{ $page }}</a></li>
                        @endfor
                        @if($publishers->hasMorePages())
                            <li><a href="{{ $publishers->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li><a class="disabled">&gt;</a></li>
                        @endif
                    </ul>
                </main>
            </div>
        </div>
    </section>

@endsection
