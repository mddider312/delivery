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

                                    <h4 class="card-title">Responsive embed video 16:9</h4>
                                    <p class="card-title-desc">Aspect ratios can be customized with modifier classes.
                                    </p>

                                    <!-- 16:9 aspect ratio -->
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/1y_kfWUCFDQ"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Responsive embed video 21:9</h4>
                                    <p class="card-title-desc">Aspect ratios can be customized with modifier classes.
                                    </p>

                                    <!-- 21:9 aspect ratio -->
                                    <div class="ratio ratio-21x9">
                                        <iframe src="https://www.youtube.com/embed/1y_kfWUCFDQ"></iframe>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Responsive embed video 4:3</h4>
                                    <p class="card-title-desc">Aspect ratios can be customized with modifier classes.
                                    </p>

                                    <!-- 4:3 aspect ratio -->
                                    <div class="ratio ratio-4x3">
                                        <iframe src="https://www.youtube.com/embed/1y_kfWUCFDQ"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Responsive embed video 1:1</h4>
                                    <p class="card-title-desc">Aspect ratios can be customized with modifier classes.
                                    </p>

                                    <!-- 1:1 aspect ratio -->
                                    <div class="ratio ratio-1x1">
                                        <iframe src="https://www.youtube.com/embed/1y_kfWUCFDQ"></iframe>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end col -->

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

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>