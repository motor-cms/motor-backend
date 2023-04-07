@if (Illuminate\Support\Arr::get($options, 'name_only', false))
    @if ($media == null)
        {{ trans('motor-media::backend/global.no_file') }}
    @else
        <ul class="list-unstyled">
            <li>{{$media->file_name}}</li>
            <li>{{\Motor\Backend\Helpers\Filesize::bytesToHuman($media->size)}}</li>
        </ul>
        <span class="badge badge-secondary badge-pill">{{$media->mime_type}}</span>
    @endif
@else
    @if ($media == null)
        {{ trans('motor-media::backend/global.no_file') }}
    @elseif ($media != null && in_array($media->mime_type, ['image/png', 'image/jpg', 'image/jpeg', 'video/x-m4v']))
        @if ($media->hasCustomProperty('generating'))
            <a data-caption="{{$record->description}}" data-fancybox="gallery" href="{{url('/images/generating-preview.png')}}"><img style="max-width: 150px;" class="img-thumbnail" src="{{ url('/images/generating-preview.png') }}"/></a>
        @elseif (file_exists($media->getPath()))
            <a data-caption="{{$record->description}}" data-fancybox="gallery" href="{{$media->getUrl()}}"><img style="max-width: 150px;" class="img-thumbnail" src="{{ $media->getUrl('thumb') }}"/></a>
        @else
            File not found!
        @endif
    @else
        @if (file_exists($media->getPath()))
        <a href="{{$media->getUrl()}}">{{$media->name}}</a>
        @else
            File not found!
        @endif
    @endif
@endif
