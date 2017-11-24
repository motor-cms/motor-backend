@foreach($items as $item)
    @if (has_role($item->attributes['roles']) || ($item->attributes['permissions'] != '' && has_permission($item->attributes['permissions'])))
        <li @lm-attrs($item) @if($item->hasChildren()) class="nav-item nav-dropdown" @else class="nav-item" @endif @lm-endattrs>
        @if($item->hasChildren())
        <a class="nav-link nav-dropdown-toggle" href="#">{!! $item->title !!}</a>
        <ul class="nav-dropdown-items">
            @include('motor-backend::layouts.partials.navigation-items', array('items' => $item->children()))
        </ul>
        @else
            <a class="nav-link" href="{!! $item->url() !!}">{!! $item->title !!}</a>
        @endif
    </li>
    @endif
@endforeach