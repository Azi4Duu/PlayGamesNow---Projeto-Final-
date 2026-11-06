@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'Publishers',
        'breadcrumbs' => [
            [
                'label' => 'Admin / Trashed Publishers'
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
                            <h2>Trashed Publishers</h2>
                            <p>Restore deleted publishers.</p>
                        </div>
                        <a class="btn-gk light" href="{{ route('admin.publishers.index') }}">Back to publishers</a>
                    </div>
                    <div class="admin-card">
                        <div class="admin-filter">
                            <form method="GET" action="{{ route('admin.publishers.trashed') }}">
                                <input type="text" name="search" placeholder="Search publishers..." class="form-control-gk" value="{{ request('search') }}">
                                <button type="submit" class="btn-gk light"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <a href="{{ route('admin.publishers.trashed') }}" class="btn-gk light">Clear Filters</a>
                            </form>
                        </div>
                        <div class="table-wrap">
                            <table class="gk-table">
                                <thead>
                                <tr>
                                    <th>Publisher</th>
                                    <th>Website</th>
                                    <th>Country</th>
                                    <th>Deleted at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($publishers as $publisher)
                                    <tr>
                                        <td>{{ $publisher->publisher_name }}</td>
                                        <td>{{ $publisher->website }}</td>
                                        <td>{{ $publisher->country }}</td>
                                        <td>{{ $publisher->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.publishers.restore', $publisher->id) }}" method="POST">
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
