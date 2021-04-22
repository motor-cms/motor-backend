<ul class="c-header-nav ml-auto mr-4">

    <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="c-avatar" style="width: auto;">
                @if (Auth::user() != null && ($avatar = Auth::user()->getMedia('avatar')->first()))
                    <img src="{{ $avatar->getUrl('thumb') }}" style="height: 30px;" class="img-avatar" alt="{{ Auth::user()->name }}">
                @elseif (Auth::user() != null)
                    {{ Auth::user()->name }}
                @endif
                <i class="fas fa-angle-down ml-2"></i>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right pt-0">
            <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
            <a class="dropdown-item" href="{{url('/backend/profile/edit')}}"><i class="c-icon mr-2 fa fa-user"></i> Profile</a>
            <form action="{{ url('/logout') }}" method="POST" class="form-inline">
                {{ csrf_field() }}
                <button class="dropdown-item" href="#"><i class="c-icon mr-2 fa fa-lock"></i> {{ trans('motor-backend::backend/login.sign_out') }}</button>
            </form>
        </div>
    </li>
</ul>
