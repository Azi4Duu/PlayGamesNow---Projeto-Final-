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
                </main>
            </div>
        </div>
    </section>

@endsection
