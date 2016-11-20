{!! Form::open(['route' => [$link, $record->id], 'method' => array_get($parameters, 'action'), 'style' => 'display: inline;', 'class' => 'form-inline']) !!}
<input type="submit" value="{{ $label }}" class="{{array_get($parameters, 'selector')}} btn {{array_get($parameters, 'class')}} btn-xs"/>
{!! Form::close() !!}
