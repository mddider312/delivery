<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="../assets/images/users/admin.png" alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="javascript: void(0);" class="text-dark fw-medium font-size-16"><?= session()->name ?></a>
                <p class="text-body mt-1 mb-0 font-size-13">
                    <?php
                        switch (session()->role) {
                            case "0":
                                echo "Admin";
                                break;
                            case "1":
                                echo "Staff";
                                break;
                            case "2":
                                echo "Driver";
                                break;
                            case "3":
                                echo "Partner";
                                break;
                            case "4":
                                echo "Agent";
                                break;
                        }
                    ?>
                </p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title"><?= lang('Files.Menu') ?></li>
                
                <?php
                    if (session()->role == "0" || session()->role == "1") {
                ?>
                        <li>
                            <a href="/dashboard" class="waves-effect">
                                <i class="mdi mdi-airplay"></i>
                                <span><?= lang('Files.Dashboard') ?></span>
                            </a>
                        </li>
                        
                        <li>
                            <!--
                            <a href="/shipment" class="waves-effect">
                                <i class="mdi mdi-clipboard"></i>
                                <span>Shipments</span>
                            </a>
                            -->
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-clipboard"></i>
                                <span>Shipments</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/pickup">Pickup</a></li>
                                <li><a href="/shipment">Dropoff</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-map-marker-outline"></i>
                                <span><?= lang('AppID') ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/appid"><?= lang('AppID List') ?></a></li>
                                <li><a href="/appid_add"><?= lang('Add New AppID') ?></a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-account-circle-outline"></i>
                                <span><?= lang('Staffs') ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/staff"><?= lang('Staff List') ?></a></li>
                                <li><a href="/staff_add"><?= lang('Add New Staff') ?></a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-bell"></i>
                                <span><?= lang('Announcements') ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/announcement"><?= lang('Announcement List') ?></a></li>
                                <li><a href="/announcement_add"><?= lang('Add New Announcement') ?></a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-settings"></i>
                                <span><?= lang('Master') ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/commission_type">Commission Types</a></li>
                            </ul>
                        </li>
                <?php
                    }
                    
                    if (session()->role == "2") {
                ?>
                        <li>
                            <a href="/delivery_order" class="waves-effect">
                                <i class="mdi mdi-car"></i>
                                <span>Delivery Orders</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="/delivery_history" class="waves-effect">
                                <i class="mdi mdi-history"></i>
                                <span>Delivery History</span>
                            </a>
                        </li>
                <?php
                    }
                ?>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->