@foreach($items as $item)
    @if (has_role($item->attributes['roles']) || ($item->attributes['permissions'] != '' && has_permission($item->attributes['permissions'])))
        <li @lm-attrs($item) @if($item->hasChildren()) class="c-sidebar-nav-item c-sidebar-nav-dropdown" @else class="c-sidebar-nav-item" @endif @lm-endattrs>
        @if($item->hasChildren())
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">{!! $item->title !!}</a>
        <ul class="c-sidebar-nav-dropdown-items">
            @include('motor-backend::layouts.partials.navigation-items', array('items' => $item->children()))
        </ul>
        @else
            <a class="c-sidebar-nav-link" href="{!! $item->url() !!}">{!! $item->title !!}</a>
        @endif
    </li>
    @endif
@endforeach
