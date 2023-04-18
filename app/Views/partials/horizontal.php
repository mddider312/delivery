<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="../assets/images/logo.jpeg" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/images/logo.jpeg" alt="" height="18">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../assets/images/logo.jpeg" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/images/logo.jpeg" alt="" height="18">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="topnav">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-dashboard"
                                    role="button">
                                    <?= lang('Files.Dashboard') ?> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                    <a href="/" class="dropdown-item"><?= lang('Files.Dashboard') ?> 1</a>
                                    <a href="index-2" class="dropdown-item"><?= lang('Files.Dashboard') ?> 2</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-ui-element"
                                    role="button">
                                    <?= lang('Files.UI_Elements') ?> <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"
                                    aria-labelledby="topnav-ui-element">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-alerts" class="dropdown-item"><?= lang('Files.Alerts') ?></a>
                                                <a href="ui-buttons" class="dropdown-item"><?= lang('Files.Buttons') ?></a>
                                                <a href="ui-cards" class="dropdown-item"><?= lang('Files.Cards') ?></a>
                                                <a href="ui-carousel" class="dropdown-item"><?= lang('Files.Carousel') ?></a>
                                                <a href="ui-dropdowns" class="dropdown-item"><?= lang('Files.Dropdowns') ?></a>
                                                <a href="ui-grid" class="dropdown-item"><?= lang('Files.Grid') ?></a>
                                                <a href="ui-images" class="dropdown-item"><?= lang('Files.Images') ?></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-lightbox" class="dropdown-item"><?= lang('Files.Lightbox') ?></a>
                                                <a href="ui-modals" class="dropdown-item"><?= lang('Files.Modals') ?></a>
                                                <a href="ui-rangeslider" class="dropdown-item"><?= lang('Files.Range_Slider') ?></a>
                                                <a href="ui-session-timeout" class="dropdown-item"><?= lang('Files.Session_Timeout') ?></a>
                                                <a href="ui-progressbars" class="dropdown-item"><?= lang('Files.Progress_Bars') ?></a>
                                                <a href="ui-sweet-alert" class="dropdown-item"><?= lang('Files.Sweet_Alert') ?></a>
                                                <a href="ui-tabs-accordions" class="dropdown-item"><?= lang('Files.Tabs_and_Accordions') ?></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-typography" class="dropdown-item"><?= lang('Files.Typography') ?></a>
                                                <a href="ui-video" class="dropdown-item"><?= lang('Files.Video') ?></a>
                                                <a href="ui-general" class="dropdown-item"><?= lang('Files.General') ?></a>
                                                <a href="ui-colors" class="dropdown-item"><?= lang('Files.Colors') ?></a>
                                                <a href="ui-rating" class="dropdown-item"><?= lang('Files.Rating') ?></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-app-pages"
                                    role="button">
                                    <?= lang('Files.Apps') ?> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-app-pages">

                                    <a href="calendar" class="dropdown-item"><?= lang('Files.Calendar') ?></a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-email"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Email') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="email-inbox" class="dropdown-item"><?= lang('Files.Inbox') ?></a>
                                            <a href="email-read" class="dropdown-item"><?= lang('Files.Read_Email') ?></a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-task"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Tasks') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-task">
                                            <a href="tasks-list" class="dropdown-item"><?= lang('Files.Task_List') ?></a>
                                            <a href="tasks-kanban" class="dropdown-item"><?= lang('Files.Kanban_Board') ?></a>
                                            <a href="tasks-create" class="dropdown-item"><?= lang('Files.Create_Task') ?></a>
                                        </div>
                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-components"
                                    role="button">
                                    <?= lang('Files.Components') ?> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-form"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Forms') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="form-elements" class="dropdown-item"><?= lang('Files.Form_Elements') ?></a>
                                            <a href="form-validation" class="dropdown-item"><?= lang('Files.Form_Validation') ?></a>
                                            <a href="form-advanced" class="dropdown-item"><?= lang('Files.Form_Advanced') ?></a>
                                            <a href="form-editors" class="dropdown-item"><?= lang('Files.Form_Editors') ?></a>
                                            <a href="form-uploads" class="dropdown-item"><?= lang('Files.Form_File_Upload') ?></a>
                                            <a href="form-xeditable" class="dropdown-item"><?= lang('Files.Form_Xeditable') ?></a>
                                            <a href="form-repeater" class="dropdown-item"><?= lang('Files.Form_Repeater') ?></a>
                                            <a href="form-wizard" class="dropdown-item"><?= lang('Files.Form_Wizard') ?></a>
                                            <a href="form-mask" class="dropdown-item"><?= lang('Files.Form_Mask') ?></a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-table"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Tables') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-table">
                                            <a href="tables-basic" class="dropdown-item"><?= lang('Files.Basic_Tables') ?></a>
                                            <a href="tables-datatable" class="dropdown-item"><?= lang('Files.Data_Tables') ?></a>
                                            <a href="tables-responsive" class="dropdown-item"><?= lang('Files.Responsive_Table') ?></a>
                                            <a href="tables-editable" class="dropdown-item"><?= lang('Files.Editable_Table') ?></a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-charts"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Charts') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                            <a href="charts-apex" class="dropdown-item"><?= lang('Files.Apex_charts') ?></a>
                                            <a href="charts-chartjs" class="dropdown-item"><?= lang('Files.Chartjs_Chart') ?></a>
                                            <a href="charts-flot" class="dropdown-item"><?= lang('Files.Flot_Chart') ?></a>
                                            <a href="charts-knob" class="dropdown-item"><?= lang('Files.Jquery_Knob_Chart') ?></a>
                                            <a href="charts-sparkline" class="dropdown-item"><?= lang('Files.Sparkline_Chart') ?></a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-icons"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Icons') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                            <a href="icons-boxicons" class="dropdown-item"><?= lang('Files.Boxicons') ?></a>
                                            <a href="icons-materialdesign" class="dropdown-item"><?= lang('Files.Material_Design') ?></a>
                                            <a href="icons-dripicons" class="dropdown-item"><?= lang('Files.Dripicons') ?></a>
                                            <a href="icons-fontawesome" class="dropdown-item"><?= lang('Files.Font_awesome') ?></a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-map"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Maps') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-map">
                                            <a href="maps-google" class="dropdown-item"><?= lang('Files.Google_Maps') ?></a>
                                            <a href="maps-vector" class="dropdown-item"><?= lang('Files.Vector_Maps') ?></a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-layouts"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= lang('Files.Layouts') ?> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);"
                                                    id="topnav-vertical" role="button" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <?= lang('Files.Vertical') ?> <div class="arrow-down"></div>

                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="topnav-vertical">
                                                    <a href="layouts-compact-sidebar" class="dropdown-item"><?= lang('Files.Compact_Sidebar') ?></a>
                                                    <a href="layouts-icon-sidebar" class="dropdown-item"><?= lang('Files.Icon_Sidebar') ?></a>
                                                    <a href="layouts-boxed" class="dropdown-item"><?= lang('Files.Boxed_Layout') ?></a>
                                                    <a href="layouts-preloader" class="dropdown-item"><?= lang('Files.Preloader') ?></a>
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="javascript: void(0);"
                                                    id="topnav-horizontal" role="button" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <?= lang('Files.Horizontal') ?><div class="arrow-down"></div>

                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="topnav-horizontal">
                                                    <a href="layouts-horizontal"
                                                        class="dropdown-item"><?= lang('Files.Horizontal') ?></a>
                                                    <a href="layouts-hori-topbarlight" class="dropdown-item"><?= lang('Files.Topbar_Light') ?></a>
                                                    <a href="layouts-hori-boxed" class="dropdown-item"><?= lang('Files.Boxed_Layout') ?></a>
                                                    <a href="layouts-hori-preloader"
                                                        class="dropdown-item"><?= lang('Files.Preloader') ?></a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript: void(0);" id="topnav-pages" role="button"
                                   >
                                   <?= lang('Files.Pages') ?> <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-lg dropdown-menu-end"
                                    aria-labelledby="topnav-pages">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>

                                                <a href="pages-login" class="dropdown-item"><?= lang('Files.Login') ?></a>
                                                <a href="pages-register" class="dropdown-item"><?= lang('Files.Register') ?></a>
                                                <a href="pages-recoverpw" class="dropdown-item"><?= lang('Files.Recover_Password') ?></a>
                                                <a href="pages-lock-screen" class="dropdown-item"><?= lang('Files.Lock_Screen') ?></a>
                                                <a href="pages-starter" class="dropdown-item"><?= lang('Files.Starter_Page') ?></a>
                                                <a href="pages-invoice" class="dropdown-item"><?= lang('Files.Invoice') ?></a>
                                                <a href="pages-profile" class="dropdown-item"><?= lang('Files.Profile') ?></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>

                                                <a href="pages-maintenance" class="dropdown-item"><?= lang('Files.Maintenance') ?></a>
                                                <a href="pages-comingsoon" class="dropdown-item"><?= lang('Files.Coming_Soon') ?></a>
                                                <a href="pages-timeline" class="dropdown-item"><?= lang('Files.Timeline') ?></a>
                                                <a href="pages-faqs" class="dropdown-item"><?= lang('Files.FAQs') ?></a>
                                                <a href="pages-pricing" class="dropdown-item"><?= lang('Files.Pricing') ?></a>
                                                <a href="pages-404" class="dropdown-item"><?= lang('Files.Error_404') ?></a>
                                                <a href="pages-500" class="dropdown-item"><?= lang('Files.Error_500') ?></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?= lang('Files.Search') ?>"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?php
                            $session = \Config\Services::session();
                            $lang = $session->get('lang');
                            switch($lang){
                                case 'en':
                                echo '<img src="../assets/images/flags/us.jpg" alt="Header Language" height="16">';
                                    break;
                                case 'es':
                                echo '<img src="../assets/images/flags/spain.jpg" alt="Header Language" height="16">';
                                    break;
                                case 'de':
                                echo '<img src="../assets/images/flags/germany.jpg" alt="Header Language" height="16">';
                                    break;
                                case 'it':
                                echo '<img src="../assets/images/flags/italy.jpg" alt="Header Language" height="16">';
                                    break;
                                case 'ru':
                                echo '<img src="../assets/images/flags/russia.jpg" alt="Header Language" height="16">';
                                    break;
                                default:
                                    echo '<img src="../assets/images/flags/us.jpg" alt="Header Language" height="16">';
                            }
                        ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="<?= base_url('lang/en'); ?>" class="dropdown-item notify-item">
                            <img src="../assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url('lang/es'); ?>" class="dropdown-item notify-item">
                            <img src="../assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle">Spanish</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url('lang/de'); ?>" class="dropdown-item notify-item">
                            <img src="../assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle">German</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url('lang/it'); ?>" class="dropdown-item notify-item">
                            <img src="../assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle">Italian</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url('lang/ru'); ?>" class="dropdown-item notify-item">
                            <img src="../assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle">Russian</span>
                        </a>
                    </div>
                </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="badge rounded-pill bg-danger ">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?= lang('Files.Notifications') ?> </h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="small"> <?= lang('Files.View_All') ?></a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex align-items-start">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1"><?= lang('Files.Your_order_is_placed') ?></h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.If_several_languages_coalesce_the_grammar') ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.min_ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex align-items-start">
                                <img src="../assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1"><?= lang('Files.It_will_seem_like_simplified_English') ?></p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.hours_ago') ?></p>
                                </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex align-items-start">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1"><?= lang('Files.Your_item_is_shipped') ?></h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.If_several_languages_coalesce_the_grammar') ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.min_ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="d-flex align-items-start">
                                <img src="../assets/images/users/avatar-4.jpg" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.As_a_skeptical_Cambridge_friend_of_mine_occidental') ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.hours_ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 " href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-3"></i><?= lang('Files.View_More') ?></a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="../assets/images/users/avatar-2.jpg"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">Patrick</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="/pages-profile"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                    <?= lang('Files.Profile') ?></a>
                    <a class="dropdown-item" href="/pages-lock-screen"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                    <?= lang('Files.Lock_screen') ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/pages-login"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <?= lang('Files.Logout') ?></a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-settings-outline"></i>
                </button>
            </div>
        </div>
    </div>
</header>