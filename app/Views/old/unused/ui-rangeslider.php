<?= $this->include('partials/main') ?>

<head>

    <?= $title_meta ?>

    <!-- ION Slider css -->
    <link href="assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />

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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">ION Range slider</h4>
                                <p class="card-title-desc">Cool, comfortable, responsive and easily customizable
                                    range slider</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Default</h5>
                                            <input type="text" id="range_01">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Min-Max</h5>
                                            <input type="text" id="range_02">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Prefix</h5>
                                            <input type="text" id="range_03">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Range</h5>
                                            <input type="text" id="range_04">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Step</h5>
                                            <input type="text" id="range_05">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Custom Values</h5>
                                            <input type="text" id="range_06">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Prettify Numbers</h5>
                                            <input type="text" id="range_07">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Disabled</h5>
                                            <input type="text" id="range_08">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Extra Example</h5>
                                            <input type="text" id="range_09">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Use decorate_both option</h5>
                                            <input type="text" id="range_10">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Postfixes</h5>
                                            <input type="text" id="range_11">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <h5 class="font-size-14 mb-3">Hide</h5>
                                            <input type="text" id="range_12">
                                        </div>
                                    </div>
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

<!-- Ion Range Slider-->
<script src="assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<!-- Range slider init js-->
<script src="assets/js/pages/range-sliders.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>