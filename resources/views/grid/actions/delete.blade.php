{!! Form::open(['route' => [$link, $record->id], 'method' => 'DELETE', 'style' => 'display: inline;', 'class' => 'form-inline']) !!}
<button type="submit" data-button-type="delete" data-record-id="{{$record->id}}" class="delete-record btn btn-danger @defaultButtonSize">{{ $label }}</button>
{!! Form::close() !!}
