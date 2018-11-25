<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('motor-backend::layouts.partials.htmlheader')
@show

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show @if (isset($motorShowRightSidebar) && $motorShowRightSidebar == true) aside-menu-lg-show @endif">

<header class="app-header navbar">
</header>



<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{asset(config('motor-backend-project.logo-small'))}}" width="89">
        <img class="navbar-brand-minimized" src="{{asset(config('motor-backend-project.logo-small'))}}" width="30">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>


    @include('motor-backend::layouts.partials.mainheader')

    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

</header>

<div id="app" class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            @if (isset($backendNavigation))
                <ul class="nav">
                    @include('motor-backend::layouts.partials.navigation-items', array('items' => $backendNavigation->roots()))
                </ul>
            @endif
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>

    <!-- Main content -->
    <main class="main">

        @include('motor-backend::layouts.partials.breadcrumbs')

        <div class="container-fluid">
            @include('motor-backend::layouts.partials.contentheader')
            @yield('main-content')
        </div>
        <!-- /.conainer-fluid -->
    </main>

    <aside class="aside-menu">
        @yield('right-sidebar')
    </aside>


</div>

@include('motor-backend::layouts.partials.footer')

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