<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{asset('template')}}/analytics/analytics-index.html" class="logo">
            <span>
                <img src="{{asset('template')}}/assets/images/logo-sm.png" alt="logo-small" class="logo-sm">
            </span>
            <span>
                <img src="{{asset('template')}}/assets/images/logo.png" alt="logo-large" class="logo-lg logo-light">
                <img src="{{asset('template')}}/assets/images/logo-dark.png" alt="logo-large" class="logo-lg ">
            </span>
        </a>
    </div>
    <!--end logo-->
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('template')}}/assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle" />
                    <span class="ml-1 nav-user-name hidden-sm"><?= Session::get('username') ?><i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg"><i class="dripicons-gear text-muted mr-2"></i> Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= route('logout') ?>"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                </div>
            </li>
        </ul><!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <button class="button-menu-mobile nav-link waves-effect waves-light">
                    <i class="dripicons-menu nav-icon"></i>
                </button>
            </li>

        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->
