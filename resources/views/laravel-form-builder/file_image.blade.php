<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name, $options['label'], $options['label_attr'])?>
<?php endif; ?>

        <div class="clearfix"></div>
        @if (isset($options['image']))
            {!! Form::hidden($options['name_slug'].'_delete') !!}
            <div class="{{$options['name_slug']}}-container">
                <div class="pull-left">
                    <img src="{{ $options['image'] }}"/>
                </div>
                <div class="pull-right">
                    <button class="btn btn-danger btn-sm {{$options['name_slug']}}-delete"><i class="fa fa-trash"></i></button>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif

    <?php if ($showField): ?>
    <?= Form::input('file', $name, $options['value'], $options['attr']) ?>

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
        $('.{{$options['name_slug']}}-delete').click(function (e) {
            e.preventDefault();
            if (!confirm('{!! trans('motor-backend::backend/global.delete_question') !!}')) {
                return false;
            }
            $('div.{{$options['name_slug']}}-container').addClass('hide');
            $('input[name="{{$options['name_slug'].'_delete'}}"]').val(1);
            return false;
        });
    </script>
@append