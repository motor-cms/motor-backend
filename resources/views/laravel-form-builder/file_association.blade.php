<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name, $options['label'], $options['label_attr'])?>
    <?php endif; ?>

    <div class="clearfix"></div>
    <input type="hidden" name="{{$options['name']}}" value="{{ $options['file_association'] }}">
    <motor-backend-file-association :name="'{{ $options['name'] }}'" :file="{{ json_encode($options['file_association']) }}"></motor-backend-file-association>
    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>