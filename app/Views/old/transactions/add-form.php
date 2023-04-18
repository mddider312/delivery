<?= $this->include('partials/main') ?>

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/head-css') ?>
</head>

<?= $this->include('partials/body') ?>

<style>
    select option:disabled {
        color: black;
        background: #D3D3D3;
    }
    
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
</style>

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
                                <h4 class="card-title mb-4"><?= lang('Files.Add_New_Transaction') ?></h4>

                                <form action="<?= base_url('save_transaction');?>" method="POST">
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Partner Name') ?></label>
                                                <select class="form-control" name="partner_id" required>
                                                    <option hidden>--Please Select--</option>
                                                    <?php foreach($partners as $partner){ ?>
                                                        <option value="<?=  $partner['id']; ?>"><?=  $partner['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Driver Name') ?></label>
                                                <select name="staff_id" class="form-control" required>
                                                    <option hidden>--Please Select--</option>
                                                    <?php foreach($drivers as $driver){ ?>
                                                        <option value="<?=  $driver['id']; ?>"><?=  $driver['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <br>
                                    <h4 class="card-title mb-4">Transaction Products:</h4>
                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-centered mb-0" id="order-list">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Product Name</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-sm-8">
                                                        <select class="form-control js-example-basic-single" name="product_id[]" onchange="$('#qty1').prop('readonly', false);" required>
                                                            <option hidden>--Please Select--</option>
                                                            <?php
                                                                foreach ($products as $p) {
                                                                    if ($p['quantity'] == 0) {
                                                                        $status = "danger";
                                                                    } else if ($p['quantity'] <= 10) {
                                                                        $status = "warning";
                                                                    } else {
                                                                        $status = "success";
                                                                    }
                                                            ?>
                                                                    <option value="<?= $p['id'] ?>" <?= $p['quantity'] == 0 ? 'disabled' : '' ?> onclick="$('#qty1').prop('max', <?= $p['quantity'] ?>);"><?= $p['name'] ?? 'n/a' ?> (<?= $p['quantity'] ?> pcs)</option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td class="col-sm-3">
                                                        <input type="text" name="quantity[]'" id="qty1" step="0.01" class="form-control" onkeypress="return isNumber(event);" required readonly/>
                                                    </td>
                                                    <td class="col-sm-1 text-center">
                                                        <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove();">
                                                            <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                    
                                    <br>
                                    
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
    var counter = parseInt(1);
    var products = <?= json_encode($products) ?>;
    
    $(document).ready(function() {
        $('.js-example-basic-single').select2({});
    });
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function addRow() {
        counter += 1;
        
          var newRow = $("<tr>");
          var cols = "";
          cols += `
            <td class="col-sm-8">
                <select class="form-control js-example-basic-single" name="product_id[]" onchange="$('#qty`+counter+`').prop('readonly', false);" required>
                    <option hidden>--Please Select--</option>
                    <?php
                        foreach ($products as $p) {
                    ?>
                            <option value="<?= $p['id'] ?>" <?= $p['quantity'] == 0 ? 'disabled' : '' ?> onclick="$('#qty`+counter+`').prop('max', <?= $p['quantity'] ?>);"><?= $p['name'] ?? 'n/a' ?> (<?= $p['quantity'] ?> pcs)</option>
                    <?php
                        }
                    ?>
                </select>
            </td>
            <td class="col-sm-3">
                <input type="text" name="quantity[]'" id="qty`+ counter +`" step="0.01" class="form-control" onkeypress="return isNumber(event);" required readonly/>
            </td>
            <td class="col-sm-1 text-center">
                <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove();">
                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                </a>
            </td>
          `;
          newRow.append(cols);
          $("#order-list").append(newRow);
          $('.js-example-basic-single').select2({});
    }
</script>

</body>

</html>