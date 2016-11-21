<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name, $options['label'], $options['label_attr'])?>
<?php endif; ?>

    <?php if ($showField): ?>
    <?php $emptyVal = $options['empty_value'] ? [ '' => $options['empty_value'] ] : null; ?>
    <?= Form::select($name, (array) $emptyVal + $options['choices'], $options['selected'], $options['attr']) ?>
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
        $(document).ready(function() {
            $('#{{$name}}').select2();
        });
    </script>
@append

