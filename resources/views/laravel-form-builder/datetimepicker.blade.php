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
    <script type="text/javascript">
        $(function () {
            $('input[name="{{$name}}_picker"]').datetimepicker({
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
            $('input[name="{{$name}}_picker"]').on('dp.change', function (e) {
                $('input[name="{{$name}}"]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
            });
            $('input[name="{{$name}}_picker"]').on('change.datetimepicker', function (e) {
                $('input[name="{{$name}}"]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
            });
        });
    </script>
@append

