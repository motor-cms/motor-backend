<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name.'_picker', $options['label'], $options['label_attr'])?>
<?php endif; ?>

    <?php if ($showField): ?>
    <?= Form::input('hidden', $name, $options['value']) ?>
    <?= Form::input('text', $name.'_picker', ($options['value'] ? date('d.m.Y H:i:s', strtotime($options['value'])) : ''), array_merge(['data-target' => "#".$name.'_picker'], $options['attr'])) ?>
    @include ('laravel-form-builder::help_block')
    <?php endif; ?>

    @include ('laravel-form-builder::errors')

    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>

@section('view_scripts')
    <script type="module">
        console.log('[datetimepicker] script loaded for "{{$name}}"');
        console.log('[datetimepicker] typeof $:', typeof $);
        console.log('[datetimepicker] typeof window.$:', typeof window.$);
        console.log('[datetimepicker] typeof jQuery:', typeof jQuery);
        console.log('[datetimepicker] typeof window.jQuery:', typeof window.jQuery);
        const jq = window.$ || window.jQuery;
        if (!jq) {
            console.error('[datetimepicker] jQuery not available!');
        } else {
            console.log('[datetimepicker] $.fn.datetimepicker:', typeof jq.fn.datetimepicker);
            const $el = jq('input[name="{{$name}}_picker"]');
            console.log('[datetimepicker] found elements:', $el.length);
            if (typeof jq.fn.datetimepicker === 'function') {
                jq(function () {
                    jq('input[name="{{$name}}_picker"]').datetimepicker({
                        locale: 'de',
                        defaultDate: false,
                        icons: {
                            time: 'far fa-clock',
                            date: 'far fa-calendar-alt',
                            up: 'fas fa-arrow-up',
                            down: 'fas fa-arrow-down',
                            previous: 'fas fa-chevron-left',
                            next: 'fas fa-chevron-right',
                            today: 'far fa-calendar-check-o',
                            clear: 'far fa-trash',
                            close: 'far fa-times'
                        }
                    });
                    console.log('[datetimepicker] initialized OK');
                    jq('input[name="{{$name}}_picker"]').on('dp.change', function (e) {
                        jq('input[name="{{$name}}"]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
                    });
                    jq('input[name="{{$name}}_picker"]').on('change.datetimepicker', function (e) {
                        jq('input[name="{{$name}}"]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
                    });
                });
            } else {
                console.error('[datetimepicker] $.fn.datetimepicker is not a function — plugin not loaded');
            }
        }
    </script>
@append

