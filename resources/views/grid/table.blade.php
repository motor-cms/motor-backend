<div class="@boxBody table-responsive no-padding">
    <table class="table table-hover" {!! $grid->buildAttributes() !!}>
        <thead>
        <tr>
            @foreach ($grid->getColumns() as $column)
                <th{!! $column->buildAttributes() !!}>
                    {!! $column->getLabel() !!}
                    @if ($column->isSortable())
                        @if ($grid->checkSortable($column->getSortableField(), 'ASC'))
                            <span class="fa fa-chevron-up"></span>
                        @else
                            <a href="{{ $grid->getSortableLink($column->getSortableField(), 'ASC') }}">
                                <span class="fa fa-chevron-up"></span>
                            </a>
                        @endif
                        @if ($grid->checkSortable($column->getSortableField(), 'DESC'))
                            <span class="fa fa-chevron-down"></span>
                        @else
                            <a href="{{ $grid->getSortableLink($column->getSortableField(), 'DESC') }}">
                                <span class="fa fa-chevron-down"></span>
                            </a>
                        @endif
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @if ($paginator->count() == 0)
            <tr><td colspan="{!! count($grid->getColumns()) !!}">{{ trans('motor-backend::backend/global.no_records') }}</td></tr>
        @endif
        @foreach ($grid->getRows() as $row)
            <tr{!! $row->buildAttributes() !!}>
                @foreach ($row->getCells() as $cell)
                    <td{!! $cell->buildAttributes() !!}>{!! $cell->getValue() !!}</td>
                @endforeach
            </tr>
        @endforeach
        @foreach ($grid->getSpecialRows() as $row)
            <tr class="special">
                <td colspan="{!! count($grid->getColumns()) !!}">{!! $row->render($paginator) !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@section('view_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ask-for-confirmation').on('click', function(e) {
                var message = $(this).data('message');
                console.log(message);
                if (message == '' || message == undefined) {
                    message = '{{trans('motor-backend::backend/global.are_you_sure')}}';
                }

                if (!confirm(message)) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@append