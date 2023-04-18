<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-end">

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="../assets/images/users/admin.png"
                            alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1"><?= session()->name ?></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-danger" href="/logout"><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <?= lang('Files.Logout') ?></a>
                    </div>
                </div>
            </div>
            <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="../assets/images/logo.png" alt="logo" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="../assets/images/logo.png" alt="logo" height="50">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="../assets/images/logo.png" alt="logo" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="../assets/images/logo.png" alt="logo" height="50">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>