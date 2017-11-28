<select name="{{ $name }}" value="{{ $value }}" class="form-control">
    @if (isset($emptyOptionString) && !is_null($emptyOptionString))
        <option value="">{{ $emptyOptionString }}</option>
    @else
        <option value="">{{ trans('motor-backend::backend/global.please_choose') }}</option>
    @endif
    @foreach ($options as $optionValue => $optionLabel)
        @if ($value == $optionValue && $value != '')
            <option value="{{$optionValue}}" selected>{{$optionLabel}}</option>
        @else
            <option value="{{$optionValue}}">{{$optionLabel}}</option>
        @endif
    @endforeach
</select>
