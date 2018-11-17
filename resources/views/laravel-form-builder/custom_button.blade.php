<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
        <?php endif; ?>
        <?php endif; ?>

        <?php if ($showLabel && $options['label'] !== false): ?>
        <?=Form::label($name, $options['label'], $options['label_attr'])?><br>
        <?php endif; ?>

        <?php if ($showField): ?>
            @if ($options['tag'] == 'div')
                <div class="btn btn-sm {{$options['attr']['class']}}"> @if (isset($options['attr']['icon']))<i class="{{$options['attr']['icon']}}"></i>@endif </div>
            @elseif ($options['tag'] == 'button')
                <button class="btn btn-sm {{$options['attr']['class']}}"> @if (isset($options['attr']['icon']))<i class="{{$options['attr']['icon']}}"></i>@endif </button>
            @endif
        <?php endif; ?>

        <?php if ($showLabel && $showField): ?>
        <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
