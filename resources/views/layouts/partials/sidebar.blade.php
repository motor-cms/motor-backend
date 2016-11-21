<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    @if ($avatar = Auth::user()->getMedia('avatar')->first())
                        <img src="{{ $avatar->getUrl('thumb') }}" class="img-circle" alt="User Image"/>
                    @else
                        <img src="{{asset(config('motor-backend-project.logo-white'))}}" class="img-circle" alt="User Image" />
                    @endif
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        {{--
        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        --}}
    <!-- Sidebar Menu -->

        @if (isset($backendNavigation))
            <ul class="sidebar-menu">
                <li class="header">Menu</li>
                @include('motor-backend::layouts.partials.navigation-items', array('items' => $backendNavigation->roots()))
            </ul>
        @endif
    </section>
    <!-- /.sidebar -->
</aside>
