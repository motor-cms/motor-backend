<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name.'_picker', $options['label'], $options['label_attr'])?>
<?php endif; ?>

    <?php if ($showField): ?>
    <?= Form::textarea($name, $options['value'], array_merge($options['attr'], ['style' => 'height: 500px'])) ?>

    @include ('laravel-form-builder::help_block')
    <?php endif; ?>

    @include ('laravel-form-builder::errors')

    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>

@section('view_scripts')
    <style type="text/css">
        .ck-editor__editable_inline {
            padding: 1.5rem;
        }
    </style>
    <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( '{{$name}}', {
            toolbar: [
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'RemoveFormat' ] },
                @if (isset($options['format']) && $options['format'] == true)
                { name: 'styles', items: [ 'Format' ] },
                @endif
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList' ] },
                @if (isset($options['links']) && $options['links'] == true)
                { name: 'links', items: [ 'Link', 'Unlink' ] },
                @endif
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            // removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Specialchar',
            format_tags: 'p;h1;h2;h3;h4;h5',
            stylesSet: []
        } );
    </script>
@append

