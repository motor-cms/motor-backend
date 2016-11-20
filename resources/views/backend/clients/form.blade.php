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
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('backend/client_profiles.push_notification_server') }}</h3>
    </div>
    <div class="box-body">
        {!! form_row($form->profile->pns_app_id) !!}
        {!! form_row($form->profile->pns_api_key) !!}
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('backend/client_profiles.app_store_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_row($form->profile->apple_app_id) !!}
        {!! form_row($form->profile->android_app_id) !!}
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('backend/client_profiles.project_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_row($form->profile->client_number) !!}
        {!! form_row($form->profile->opt_in_email_template_id) !!}
        {!! form_row($form->profile->password_forgotten_email_template_id) !!}
        {!! form_row($form->profile->contact_email_template_id) !!}
        {!! form_row($form->profile->personal_shopping_email_template_id) !!}
        {!! form_row($form->profile->invitation_email_template_id) !!}
        {!! form_row($form->profile->code_type) !!}
        {!! form_row($form->profile->footer) !!}
        {!! form_row($form->profile->logo) !!}
        {!! form_row($form->profile->app_logo) !!}
    </div>
    <div class="box-footer">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
