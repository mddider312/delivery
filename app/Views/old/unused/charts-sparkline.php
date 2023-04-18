<?= $this->include('partials/main') ?>

<head>

    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

</head>

<?= $this->include('partials/body') ?>

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?= $this->include('partials/menu') ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <?= $page_title ?>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Pie Chart</h4>
                                    <div id="sparkline1" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Bar Chart</h4>
                                    <div id="sparkline2" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body analytics-info">
                                    <h4 class="card-title">Line Chart</h4>
                                    <div id="sparkline4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Composite Bar Chart</h4>
                                    <div id="sparkline3" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Line Charts</h4>
                                    <div id="sparkline5" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <h4 class="card-title text-white">Discrete Chart</h4>
                                    <div id="sparkline6" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Bullet Chart</h4>
                                    <div id="sparkline7"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Box Plot Chart</h4>
                                    <div id="sparkline8" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tristate Charts</h4>
                                    <div id="sparkline9" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                <!-- End Page-content -->

                <?= $this->include('partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <?= $this->include('partials/right-sidebar') ?>

    <!-- JAVASCRIPT -->
    <?= $this->include('partials/vendor-scripts') ?>

    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <script src="assets/js/pages/sparklines.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>