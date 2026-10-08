@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close position-static" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-4">
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close position-static" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
