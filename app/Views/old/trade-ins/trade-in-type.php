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

                                <form action="<?= base_url('update_trade_in_type');?>" method="POST">
                                    <input type="hidden" name="_method" value="PUT" />
                                    
                                    <?= $this->include('partials/alert') ?>

                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-centered table-bordered mb-0" id="trade-in-type-list">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center">Type</th>
                                                    <th colspan="2" class="text-center">Value (RM)</th>
                                                    <th rowspan="2" class="text-center">Actions</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">With Order</th>
                                                    <th class="text-center">Without Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($trade_in_types as $trade_in_type) {
                                                ?>
                                                        <tr>
                                                            <input name="trade_in_type_id[]" value="<?= $trade_in_type['trade_in_type_id'] ?>" hidden>
                                                            <td class="col-sm-5">
                                                                <input type="text" name="type[]" class="form-control" value="<?= $trade_in_type['type'] ?>">
                                                            </td>
                                                            <td class="col-sm-3">
                                                                <input type="text" name="value_with_order[]'" step="0.01" class="form-control" onkeypress="return isNumber(event);" value="<?= $trade_in_type['value_with_order'] ?>"/>
                                                            </td>
                                                            <td class="col-sm-3">
                                                                <input type="text" name="value_without_order[]'" step="0.01" class="form-control" onkeypress="return isNumber(event);" value="<?= $trade_in_type['value_without_order'] ?>"/>
                                                            </td>
                                                            <td class="col-sm-1 text-center">
                                                                <a href="<?= base_url('delete_trade_in_type/'.$trade_in_type['trade_in_type_id']) ?>" class="ibtnDel btn btn-xs btn-danger" onclick="return confirm('Delete this trade-in type');">
                                                                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                
                                    <br><br>
                                    
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        <?= lang('Files.Update') ?>
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
    var counter = parseInt(<?= COUNT($trade_in_types) ?>);

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

    function addRow() {
        counter += 1;
        
          var newRow = $("<tr>");
          var cols = "";
          cols += `
            <td class="col-sm-5">
                <input type="text" name="type[]" class="form-control">
            </td>
            <td class="col-sm-3">
                <input type="text" name="value_with_order[]'" step="0.01" class="form-control" onkeypress="return isNumber(event);"/>
            </td>
            <td class="col-sm-3">
                <input type="text" name="value_without_order[]'" step="0.01" class="form-control" onkeypress="return isNumber(event);"/>
            </td>
            <td class="col-sm-1 text-center">
                <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove();">
                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                </a>
            </td>
          `;
          newRow.append(cols);
          $("#trade-in-type-list").append(newRow);
    }
</script>

</body>

</html>