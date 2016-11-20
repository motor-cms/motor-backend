@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-backend::backend/email_templates.email_templates') }}
    {!! link_to_route('backend.email_templates.create', trans('motor-backend::backend/email_templates.new'), [], ['class' => 'pull-right btn btn-sm btn-success']) !!}
@endsection

@section('main-content')
    <div class="box">
        <div class="box-header">
            @include('motor-backend::layouts.partials.search')
        </div>
        <!-- /.box-header -->
        @if (isset($grid))
            @include('motor-backend::grid.table')
        @endif
    </div>
@endsection

@section('view_scripts')
    <script type="text/javascript">
        $('.delete-record').click(function (e) {
            if (!confirm('{!! trans('motor-backend::backend/global.delete_question') !!}')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endsection