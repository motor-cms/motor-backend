<form class="form-inline">
    @foreach ($grid->filter->filters() as $filter)
        {!! $filter->render() !!}
    @endforeach
    <div class="input-group input-group-sm">
        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
    </div>
</form>
<div class="box-tools">
    {!! $paginator->appends(['search' => $grid->getSearchTerm() ])->links() !!}
</div>
