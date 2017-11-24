<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('motor-backend::layouts.partials.htmlheader')
@show

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="#"></a>

    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    @include('motor-backend::layouts.partials.mainheader')

    <button class="navbar-toggler aside-menu-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

</header>

<div class="app-body">
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
</script>

</body>
</html>