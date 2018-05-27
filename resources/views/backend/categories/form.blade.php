{!! form_start($form, ['id' => 'category-item']) !!}
<div class="row">
    <div class="col-md-8">
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
            </div>
            <div class="@boxBody">
                {!! form_row($form->name) !!}
            </div>
            <!-- /.box-body -->

            <div class="@boxFooter">
                {!! form_row($form->submit) !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('motor-backend::backend/category_trees.category_tree') }}</h3>
            </div>
            <div class="@boxBody">
                <div id="category-tree">
                    @include('motor-backend::layouts.partials.category-tree-items', array('items' => $trees, 'newItem' => $newItem, 'selectedItem' => $selectedItem))
                </div>
            </div>
        </div>
    </div>

</div>
{!! form_end($form) !!}

@section('view_scripts')
{{--    <link href="{{asset('plugins/jstree/themes/default/style.css')}}" rel="stylesheet" type="text/css"/>--}}
{{--    <script src="{{asset('plugins/jstree/jstree.min.js')}}"></script>--}}
    <script>
        $.jstree.defaults.dnd.is_draggable = function (node) {
            var id = $(node).attr('id');
            if (id != 'category-item') {
                return false;
            }
            return true;
        };

        $('#category-tree').jstree(
            {
                "core": {
                    "check_callback": true
                },
                "plugins": ["dnd"]
            }
        );

        $(document).on('dnd_stop.vakata', function (event, element) {
            $.each(element.data.nodes, function (index, node) {
                setTimeout(function () {
                    openNode(node)
                }, 500);
            });
        });

        var openNode = function (node) {
            var parent = $('#category-tree').jstree().get_parent(node);
            $('#category-tree').jstree().open_node(parent);

            if (parent) {
                openNode(parent);
            }
        };

        openNode('category-item');

        $('input#name').keyup(function (e) {
            $('#category-item a span.category-item-name').html($(this).val());
        });
        $('form#category-item').on('submit', function (e) {
//            e.preventDefault();

            // get item parent
            var parent = $('#category-tree').jstree().get_parent('category-item');

            $('input[name="parent_id"]').val($('#' + parent).data('category-id'));

            // get previous sibling (if any)
            var previousSibling = $('#category-tree').jstree().get_prev_dom('category-item', true);
            if (previousSibling !== false) {
                $('input[name="previous_sibling_id"]').val(previousSibling.data('category-id'));
            }

            var nextSibling = $('#category-tree').jstree().get_next_dom('category-item', true);
            if (nextSibling !== false) {
                $('input[name="next_sibling_id"]').val(nextSibling.data('category-id'));
            }
        });
    </script>
@append
