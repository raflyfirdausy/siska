<!-- BEGIN TOP MENU -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" id="nav-small-button" data-toggle="collapse" data-target="#sidebar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="menu-medium" class="sidebar-toggle tooltips">
                <i class="fa fa-outdent"></i>
            </a>
            <a class="navbar-brand" href="#"></a>
        </div>
        <div class="navbar-center">{{ option()->application_name }}</div>
        <div class="navbar-collapse collapse">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav navbar-nav pull-right header-menu">
                <!-- BEGIN USER DROPDOWN -->
                <li class="dropdown" id="user-header">
                    <a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img src="{{ asset('img/avatars/avatar2.png') }}" alt="user avatar" width="30" class="p-r-5">
                        <span class="username">{{ Auth::user()->name }}</span>
                        <i class="fa fa-angle-down p-r-10"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('logout') }}">
                                <i class="glyph-icon flaticon-logout"></i> Keluar
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
</nav>
<!-- END TOP MENU -->