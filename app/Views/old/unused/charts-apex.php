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
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Line with Data Labels</h4>

                                    <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Dashed Line</h4>

                                    <div id="line_chart_dashed" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Spline Area</h4>

                                    <div id="spline_area" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Column Charts</h4>

                                    <div id="column_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Column with Data Labels</h4>

                                    <div id="column_chart_datalabel" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Bar Chart</h4>

                                    <div id="bar_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Line, Column & Area Chart</h4>

                                    <div id="mixed_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Radial Chart</h4>

                                    <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                            <!--end card-->

                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Pie Chart</h4>

                                    <div id="pie_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Donut Chart</h4>

                                    <div id="donut_chart" class="apex-charts" dir="ltr"></div>
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

    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- apexcharts init -->
    <script src="assets/js/pages/apexcharts.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>