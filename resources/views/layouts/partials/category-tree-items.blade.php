@foreach($items as $item)
    <ul>
        @if ($newItem)
            <li data-jstree='{ "icon" : "fa fa-folder-open", "opened": true }' data-category-id="{{$item->id}}">{{$item->name}}
                @include('motor-backend::layouts.partials.category-tree-items', array('items' => $item->children, 'newItem' => false, 'selectedItem' => $selectedItem))
                <ul>
                    <li data-jstree='{ "icon" : "fa fa-file" }' id="category-item"><span class="category-item-name">{{ trans('motor-backend::backend/categories.new_category') }}</span></li>
                </ul>
            </li>
        @else
            @if ($item->id == $selectedItem)
                <li data-jstree='{ "icon" : "fa fa-file" }' id="category-item" data-category-id="{{$item->id}}">{{$item->name}}
                    @include('motor-backend::layouts.partials.category-tree-items', array('items' => $item->children, 'newItem' => false, 'selectedItem' => $selectedItem))
                </li>
            @else
                <li data-jstree='{ "icon" : "fa fa-folder-open" }' data-category-id="{{$item->id}}">{{$item->name}}
                    @include('motor-backend::layouts.partials.category-tree-items', array('items' => $item->children, 'newItem' => false, 'selectedItem' => $selectedItem))
                </li>
            @endif
        @endif
    </ul>
@endforeach