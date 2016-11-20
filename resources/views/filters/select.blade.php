<select name="{{ $name }}" value="{{ $value }}" class="form-control">
    <option value="">{{ trans('motor-backend::backend/global.please_choose') }}</option>
    @foreach ($options as $optionValue => $optionLabel)
        @if ($value == $optionValue && $value != '')
            <option value="{{$optionValue}}" selected>{{$optionLabel}}</option>
        @else
            <option value="{{$optionValue}}">{{$optionLabel}}</option>
        @endif
    @endforeach
</select>
