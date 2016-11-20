{!! form_start($form) !!}
<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        {!! form_until($form, 'description') !!}
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/clients.address_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_until($form, 'country_iso_3166_1') !!}
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/clients.contact_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_until($form, 'website') !!}
    </div>
    <div class="box-footer">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
