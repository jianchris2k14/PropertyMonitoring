<!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto">
    <!-- System Links -->
    @guest

    @else
        <li class="nav-item">
            <a class="nav-link {{ Route::current()->uri=='home' ? 'active':'' }}" href="/home">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::current()->uri=='persons' || Route::current()->uri=='users' ? 'active':'' }}" data-toggle="dropdown" href="#">
                <i class="fas fa-users-cog"></i> Accessibility
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/persons">
                    <i class="fas fa-address-book"></i> Personal Informations
                </a>
                <a class="dropdown-item" href="/users">
                    <i class="fas fa-book-reader"></i> Users Management
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::current()->uri=='equipments' || Route::current()->uri=='repair_job_orders/{id}' ? 'active':'' }}" data-toggle="dropdown" href="#">
                <i class="fas fa-truck-loading"></i> Motorpol
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/equipments">
                    <i class="fas fa-box-open"></i> Equipment Informations
                </a>
                
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::current()->uri=='inventory' || Route::current()->uri=='inventory_stocks/{id}' ? 'active':'' }}" data-toggle="dropdown" href="#">
                <i class="fas fa-book"></i> Inventory
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/inventory">
                    <i class="fas fa-box-open"></i> Inventory Details
                </a>
                
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fas fa-folder-plus"></i> Purchasing
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">
                    <i class="fa fa-book"></i> Purchase Inventory
                </a>
                
            </div>
        </li>
    @endguest
</ul>

<!-- Right Side Of Navbar -->
<ul class="navbar-nav ml-auto">
    <!-- Authentication Links -->
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->username }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-external-link-alt"></i> {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
</ul>