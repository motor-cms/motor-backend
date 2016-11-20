{!! form_start($form) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_until($form, 'language_id') !!}
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/email_templates.template_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_until($form, 'body_html') !!}
    </div>

    <div class="box-footer">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
