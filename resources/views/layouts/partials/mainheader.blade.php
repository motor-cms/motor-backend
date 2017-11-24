<ul class="nav navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @if ($avatar = Auth::user()->getMedia('avatar')->first())
                <img src="{{ $avatar->getUrl('thumb') }}" class="img-avatar" alt="{{ Auth::user()->name }}">
            @else
                {{ Auth::user()->name }}
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
                <strong>Account</strong>
            </div>
            <a class="dropdown-item" href="{{url('/backend/profile/edit')}}"><i class="fa fa-user"></i> Profile</a>
            <form action="{{ url('/logout') }}" method="POST" class="form-inline">
                {{ csrf_field() }}
                <button class="dropdown-item" href="#"><i class="fa fa-lock"></i> {{ trans('motor-backend::backend/login.sign_out') }}</button>
            </form>

        </div>
    </li>
</ul>
