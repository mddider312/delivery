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
                                <h4 class="card-title mb-4"><?= lang('Files.Add_New_Voucher') ?></h4>
                                <form action="<?= base_url('save_voucher');?>" method="POST">
                                    <div class="row mb-3">
                                        <div class="col-lg-6 mb-3 ">
                                            <label class="form-label"><?= lang('Files.Voucher_name') ?></label>
                                            <input class="form-control" type="text" name="name" placeholder="Voucher name">
                                        </div>
                                        
                                        <div class="col-lg-6 mb-3">
                                            <div class="">
                                                <label class="form-label"><?= lang('Files.Voucher_code') ?></label>
                                                <input class="form-control" type="text" name="code" placeholder="Voucher code">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-3 ">
                                            <label class="form-label"><?= lang('Type') ?></label>
                                            <select class="form-select" name="type" onchange="changeAmountLabel(this.value);" required>
                                                <option hidden>--Please Select--</option>
                                                <option value="0">Percentage (%)</option>
                                                <option value="1">Amount (RM)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-3">
                                            <div class="">
                                                <label class="form-label" id="amount-label">Discount Amount</label>
                                                <input class="form-control" type="text" name="discount_amount" onkeypress="return isNumber(event);">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
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
    
    function changeAmountLabel(type) {
        if (type == 0) {
            $('#amount-label').text('Discount Percentage (%)');
        } else if (type == 1) {
            $('#amount-label').text('Discount Amount (RM)');
        }
    }
</script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/tasklist.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>