<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav ml-auto">

        <li class="nav-item d-md-down-none">
            <a class="nav-link navbar-toggler aside-menu-toggler" href="#"><i class="icon-bell"></i><span id="notification-count" class="badge badge-pill badge-light">0</span></a>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-list"></i></a>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-location-pin"></i></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ is_null(auth()->user()->employee()->first()) ? 'https://www.gravatar.com/avatar/'.md5(strtolower(trim(auth()->user()->email))).'?s=160&d=retro' : asset('storage/employee_photos/' . auth()->user()->employee()->first()->photo)}}"
                     class="img-avatar" alt="{{ Auth::user()->email }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>{{ auth()->user()->first_name }}'s Account</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
                <div class="divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Logout </a>
            </div>
        </li>
    </ul>

    <button class="navbar-toggler aside-menu-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</header>
