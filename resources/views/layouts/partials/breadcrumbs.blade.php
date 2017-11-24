<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('backend/dashboard')}}">Dashboard</a></li>

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
    {{--<!-- Breadcrumb Menu-->--}}
    {{--<li class="breadcrumb-menu d-md-down-none">--}}
    {{--<div class="btn-group" role="group" aria-label="Button group">--}}
    {{--<a class="btn" href="#"><i class="icon-speech"></i></a>--}}
    {{--<a class="btn" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>--}}
    {{--<a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>--}}
    {{--</div>--}}
    {{--</li>--}}
</ol>
