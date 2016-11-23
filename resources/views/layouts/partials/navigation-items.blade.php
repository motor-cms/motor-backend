@foreach($items as $item)
    @if (has_role($item->attributes['roles']) || ($item->attributes['permissions'] != '' && has_permission($item->attributes['permissions'])))
    <li@lm-attrs($item) @if($item->hasChildren()) class="treeview" @endif @lm-endattrs>
        <a href="{!! $item->url() !!}">{!! $item->title !!}</a>
        @if($item->hasChildren())
        <ul class="treeview-menu">
            @include('motor-backend::layouts.partials.navigation-items', array('items' => $item->children()))
        </ul>
        @endif
    </li>
    @endif
@endforeach