@if (array_get($options, 'name_only', false))
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
    @elseif ($media != null && in_array($media->mime_type, ['image/png', 'image/jpg', 'video/mp4']))
        <a data-caption="{{$record->description}}" data-fancybox="gallery" href="{{$media->getUrl()}}"><img style="max-width: 150px;" class="img-thumbnail" src="{{ $media->getUrl('thumb') }}"/></a>
    @else
        <a href="{{$media->getUrl()}}">{{$media->name}}</a>
    @endif
@endif

