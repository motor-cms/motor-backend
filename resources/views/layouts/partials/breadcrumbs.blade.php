<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{url('backend/dashboard')}}">Dashboard</a></li>

    @if (isset($backendNavigation))
        @foreach($backendNavigation->roots() as $item)
            @if ($item->isActive)
                <li class="breadcrumb-item"><a href="{!! $item->url() !!}">{!! $item->title !!}</a></li>
            @endif
            @foreach ($item->children() as $subitem)
                @if ($subitem->isActive)
                    <li class="breadcrumb-item"><a href="{!! $subitem->url() !!}">{!! $subitem->title !!}</a></li>
                @endif
            @endforeach
        @endforeach
    @endif
</ol>
