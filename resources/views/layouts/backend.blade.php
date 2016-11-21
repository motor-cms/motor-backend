<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('motor-backend::layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-mini">
<div id="app">
    <div class="wrapper">

    @include('motor-backend::layouts.partials.mainheader')

    @include('motor-backend::layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

        @include('motor-backend::layouts.partials.contentheader')

        <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('main-content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('motor-backend::layouts.partials.controlsidebar')

        @include('motor-backend::layouts.partials.footer')

    </div><!-- ./wrapper -->
</div>

@section('scripts')

    @include('motor-backend::layouts.partials.scripts')

@show

@yield('view_scripts')

</body>
</html>
