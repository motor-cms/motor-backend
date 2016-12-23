@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => session('flash_notification.title'),
            'body'       => session('flash_notification.message')
        ])
    @else
        @if (config('motor-backend.flash') == 'alert')
        <div class="flash-message">
            <p>
            <div class="alert
                    alert-{{ session('flash_notification.level') }}
            {{ session()->has('flash_notification.important') ? 'alert-important' : '' }}"
            >
                @if(session()->has('flash_notification.important'))
                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true"
                    >&times;</button>
                @endif

                {!! session('flash_notification.message') !!}
            </div>
            </p>
        </div>
        @elseif(config('motor-backend.flash') == 'toastr')
        @section('view_scripts')
            <script type="text/javascript">
                var notificationLevel = '{{ session('flash_notification.level') }}';
                toastr.options = {progressBar: true};

                switch (notificationLevel) {
                    case 'success':
                        toastr.success('{!! session('flash_notification.message') !!}', '{{ trans('motor-backend::backend/global.flash.success') }}');
                        break;
                    case 'error':
                        toastr.error('{!! session('flash_notification.message') !!}', '{{ trans('motor-backend::backend/global.flash.error') }}');
                        break;
                    case 'warning':
                        toastr.warning('{!! session('flash_notification.message') !!}', '{{ trans('motor-backend::backend/global.flash.warning') }}');
                        break;
                    case 'info':
                        toastr.info('{!! session('flash_notification.message') !!}', '{{ trans('motor-backend::backend/global.flash.info') }}');
                        break;
                }
            </script>
        @append
        @endif
    @endif
@endif
