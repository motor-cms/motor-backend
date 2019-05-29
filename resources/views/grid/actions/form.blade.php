{!! Form::open(['route' => [$link, $record->id], 'method' => Arr::get($parameters, 'action'), 'style' => 'display: inline;', 'class' => 'form-inline']) !!}
<input type="submit" value="{{ $label }}" class="{{Arr::get($parameters, 'selector')}} btn {{Arr::get($parameters, 'class')}} btn-xs"/>
{!! Form::close() !!}
