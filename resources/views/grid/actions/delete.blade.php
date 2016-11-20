{!! Form::open(['route' => [$link, $record->id], 'method' => 'DELETE', 'style' => 'display: inline;', 'class' => 'form-inline']) !!}
<input type="submit" value="{{ $label }}" class="delete-record btn btn-danger btn-xs"/>
{!! Form::close() !!}
