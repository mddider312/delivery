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
        <div class="main-content">
            <div class="page-content">
                <?= $page_title ?>
                <div class="row align-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"><?= $title ?></h4>
                                
                                <?= $this->include('partials/alert') ?>

                                <form action="<?= base_url('update_base_commission');?>" method="POST">
                                    <input type="hidden" name="_method" value="PUT" />
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Base Commission Rate (%)') ?></label>
                                                <input class="form-control" type="text" name="base_rate" value="<?= $base_commission ?>" onkeypress="return isNumber(event);" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary waves-effect waves-light mt-5" type="submit">
                                        <?= lang('Files.Submit') ?>
                                    </button>
                                </form>
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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/tasklist.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
          return true;  
        } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>

</body>

</html>