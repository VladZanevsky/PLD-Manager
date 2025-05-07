<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        @isset($breadcrumbs)
            @foreach($breadcrumbs as $breadcrumb)
                @if(!is_null($breadcrumb->url) && !$loop->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                @endif
            @endforeach
        @endisset
    </ol>
</div>
