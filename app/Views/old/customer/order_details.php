<?= $this->include('partials/main') ?>

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/head-css') ?>
</head>

<style>
    .btn:hover {
        background-color: grey;
        color: white;
    }
    
    .btn {
        background-color: #EE0263;
        border: 1px solid #EE0263;
    }
    
    body[data-layout="detached"] #layout-wrapper::before {
    	background: #EE0263 !important;
    }
    
    footer {
        background: transparent !important;
    }

</style>

<?= $this->include('partials/body') ?>
    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php $this->include('partials/menu'); ?>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex justify-content-between">
                            
                            <div class="d-flex flex-row-reverse m-0 w-100">
                                <div class="row w-100" style="padding-right:20px;">
                                    
                                    <div class="col-md-10">
                                        <img class="img-responsive mt-2 mb-5" src="<?= base_url('assets/images/logo.png') ?>" style="width: 200px;">
                                        <!--<h4 class="page-title mb-0"><?= $title ?></h4>-->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="row d-flex justify-content-center" *style="margin-top: 10%;">
                        <div class="col-12 col-xl-6 col-md-6" style="border:1px solid black; padding: 10px;">
                            <?= $order[0]['html'] ?>
                        </div>
                    </div>
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
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

    </script>
</body>

</html>