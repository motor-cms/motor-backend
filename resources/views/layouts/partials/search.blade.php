<div class="box-tools">
    {!! $paginator->appends(['search' => $grid->getSearchTerm(), 'sortable_field' => $grid->getSortableColumn(), 'sortable_direction' => $grid->getSortableDirection() ])->links('pagination::bootstrap-4') !!}
</div>
<form class="form-inline">
    @foreach ($grid->getFilter()->filters() as $filter)
        {!! $filter->render() !!}
    @endforeach
    <div class="input-group input-group-sm">
        <button type="submit" class="btn btn-outline-secondary" id="grid-search-button"><i class="fa fa-search"></i></button>
    </div>
</form>
