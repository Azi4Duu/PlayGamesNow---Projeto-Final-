<div class="page-heading compact-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>{{$title}}</h3>
                <span class="breadcrumb">
                    <a href="{{route('home')}}">Home</a>
                    @foreach($breadcrumbs as $breadcrumb)
                        &gt;
                        @if(isset($breadcrumb['route']))
                            <a href="{{ $breadcrumb['route'] }}">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    @endforeach
                </span>
            </div>
        </div>
    </div>
</div>
