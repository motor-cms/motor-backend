<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('motor-backend::layouts.partials.htmlheader')
@show

<body class="c-app">
<div id="app" style="width: 100vw;">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <img class="c-sidebar-brand-full" src="{{asset(config('motor-backend-project.logo-white-cropped'))}}"
                 width="89">
            <img class="c-sidebar-brand-minimized" src="{{asset(config('motor-backend-project.logo-white-cropped'))}}"
                 width="30">
        </div>

        @if (isset($backendNavigation))
            <ul class="c-sidebar-nav ps">
                @include('motor-backend::layouts.partials.navigation-items', array('items' => $backendNavigation->roots()))
            </ul>
        @endif
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
                data-class="c-sidebar-minimized"></button>
    </div>

    @if(View::hasSection('right-sidebar'))
        <div class="bg-secondary c-sidebar c-sidebar-right c-sidebar-fixed c-sidebar-lg-show" id="sidebar-right">
            <div class="c-sidebar-brand d-lg-down-none">@yield('right-sidebar-header')</div>
            <div style="position: relative; height: 88vh;">
                @yield('right-sidebar')
            </div>
        </div>
    @endif
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                    data-class="c-sidebar-show">
                <i class="fas fa-bars"></i>
            </button>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                    data-class="c-sidebar-lg-show" responsive="true">
                <i class="fas fa-bars"></i>
            </button>
            @include('motor-backend::layouts.partials.mainheader')
            <div class="c-subheader px-3">
                @include('motor-backend::layouts.partials.breadcrumbs')
            </div>
        </header>

        <!-- Main content -->
        <div class="c-body">
            <main class="c-main">

                <div class="container-fluid">
                    @include('motor-backend::layouts.partials.contentheader')
                    @yield('main-content')
                </div>

            </main>
            @include('motor-backend::layouts.partials.footer')
        </div>
    </div>
</div>

@routes
@section('scripts')
    @include('motor-backend::layouts.partials.scripts')
@show

@yield('view_scripts')
<script>
    $('div.flash-message .alert').not('.alert-important').delay(3000).fadeOut(350);
    $('.sidebar-nav li.active').addClass('open');
    $('.sidebar-nav li.active > a').addClass('active');
    //    $('video, audio').mediaelementplayer({
    //        // Do not forget to put a final slash (/)
    ////        pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
    //        // this will allow the CDN to use Flash without restrictions
    //        // (by default, this is set as `sameDomain`)
    //        shimScriptAccess: 'always'
    //        // more configuration
    //    });
</script>
</body>
</html>
