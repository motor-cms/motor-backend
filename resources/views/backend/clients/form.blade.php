{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <!-- /.box-header -->
    <div class="@boxBody">
        {!! form_until($form, 'description') !!}
    </div>
</div>
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/clients.address_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_until($form, 'country_iso_3166_1') !!}
    </div>
</div>
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/clients.contact_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_until($form, 'website') !!}
    </div>
    <div class="@boxFooter">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
