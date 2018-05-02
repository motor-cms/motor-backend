@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else

        @if (config('motor-backend.flash') == 'alert')
            <div class="flash-message">
                <p>
                <div class="alert
                    alert-{{ $message['level'] }}
                {{ $message['important'] ? 'alert-important' : '' }}"
                     role="alert"
                >
                    @if ($message['important'])
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true"
                        >&times;
                        </button>
                    @endif

                    {!! $message['message'] !!}
                </div>
                </p>
            </div>
        @elseif(config('motor-backend.flash') == 'toastr')
@section('view_scripts')
    <script type="text/javascript">
        var notificationLevel = '{{ $message['level'] }}';
        toastr.options = {progressBar: true};

        switch (notificationLevel) {
            case 'success':
                toastr.success('{!! $message['message'] !!}', '{{ trans('motor-backend::backend/global.flash.success') }}');
                break;
            case 'error':
            case 'danger':
                toastr.error('{!! $message['message'] !!}', '{{ trans('motor-backend::backend/global.flash.error') }}');
                break;
            case 'warning':
                toastr.warning('{!! $message['message'] !!}', '{{ trans('motor-backend::backend/global.flash.warning') }}');
                break;
            case 'info':
                toastr.info('{!! $message['message'] !!}', '{{ trans('motor-backend::backend/global.flash.info') }}');
                break;
        }
    </script>
@append
@endif
@endif
@endforeach

{{ session()->forget('flash_notification') }}
