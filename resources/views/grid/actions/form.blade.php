{!! Form::open(['route' => [$link, $record->id], 'method' => Illuminate\Support\Arr::get($parameters, 'action'), 'style' => 'display: inline;', 'class' => 'form-inline']) !!}
<input type="submit" value="{{ $label }}" class="{{Illuminate\Support\Arr::get($parameters, 'selector')}} btn {{Illuminate\Support\Arr::get($parameters, 'class')}} btn-xs"/>
{!! Form::close() !!}
