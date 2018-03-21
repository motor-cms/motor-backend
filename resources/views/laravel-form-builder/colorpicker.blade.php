<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name.'_picker', $options['label'], $options['label_attr'])?>
<?php endif; ?>

    <?php if ($showField): ?>
    <?= Form::input('text', $name, $options['value'], $options['attr']) ?>

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
        $('input[name="{{$name}}"]').minicolors({
            format: 'rgb',
            opacity: true,
            position: 'left',
            theme: 'bootstrap',
            inline: false,
        });
    </script>
@append

