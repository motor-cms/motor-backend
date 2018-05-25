@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('motor-backend-project.name') }}
        @endcomponent
    @endslot

<h1>{{trans('motor-backend::backend/login.password_forgotten_greeting')}}</h1>
<p>
    {{trans('motor-backend::backend/login.password_reset_paragraph')}}
</p>

@component('mail::button', ['url' => config('app.url').'/password/reset/'.$token])
    {{trans('motor-backend::backend/login.reset_password')}}
@endcomponent

<p>
    {{trans('motor-backend::backend/login.password_reset_paragraph_2')}}
</p>

    @slot('subcopy')
    @component('mail::subcopy')

{{trans('motor-backend::backend/login.password_reset_paragraph_3')}}

{{config('app.url').'/password/reset/'.$token}}
    @endcomponent
    @endslot

    {{-- Footer --}}
    @slot('footer')
    @component('mail::footer')
        <strong>Copyright &copy; 2016 - {{date('Y')}} {{ config('motor-backend-project.copyright') }}</strong>
@endcomponent
@endslot
@endcomponent