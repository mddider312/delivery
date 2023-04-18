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
                                <h4 class="card-title mb-4">Add New Agent</h4>
                                
                                <?= $this->include('partials/alert') ?>

                                <form action="<?= base_url('save_agent');?>" method="POST">
                                <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Agent Email</label>
                                                <input class="form-control" type="text" name="email" placeholder="">
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control" type="text" name="name" placeholder="">
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Contact No.</label>
                                                <input class="form-control" type="text" name="contact_no" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Agent Password</label>
                                                <input class="form-control" type="text" name="password" placeholder="">
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Commission (RM)</label>
                                                <input class="form-control" type="text" name="commission" placeholder="" onkeypress="return isNumber(event, 1);">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <br>
                                
                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-centered mb-0" id="partner-product-list">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center">Product Name</th>
                                                    <th colspan="2" class="text-center">Commission Rate (%)</th>
                                                    <th rowspan="2" class="text-center">Actions</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">Base</th>
                                                    <th class="text-center">Additional</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-sm-7">
                                                        <select class="form-control" name="product_id[]" onchange="$('#percentage1').prop('readonly', false); getDetails(this.value, '1');">
                                                            <option hidden>--Please Select--</option>
                                                            <?php
                                                                foreach ($products as $p) {
                                                            ?>
                                                                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td class="col-sm-2">
                                                        <input type="text" id="base1" step="0.01" class="form-control" onkeypress="return isNumber(event);" readonly/>
                                                    </td>
                                                    <td class="col-sm-2">
                                                        <input type="text" name="percentage[]" id="percentage1" step="0.01" class="form-control" onkeypress="return isNumber(event);" readonly/>
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
    
    function getDetails(product_id, counter) {
        for (var i = 0; i < products.length; i++) {
            if (products[i]['id'] == product_id) {
                $('#base' + counter).val(products[i]['commission']);
            }
        }
    }

    function addRow() {
        counter += 1;
        
          var newRow = $("<tr>");
          var cols = "";
          cols += `
            <td class="col-sm-7">
                <select class="form-control" name="product_id[]" onchange="$('#percentage`+counter+`').prop('readonly', false); getDetails(this.value, '`+counter+`');" required>
                    <option hidden>--Please Select--</option>
                    <?php
                        foreach ($products as $p) {
                    ?>
                            <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                    <?php
                        }
                    ?>
                </select>
            </td>
            <td class="col-sm-2">
                <input type="text" id="base`+ counter +`" step="0.01" class="form-control" onkeypress="return isNumber(event);" readonly/>
            </td>
            <td class="col-sm-2">
                <input type="text" name="percentage[]'" id="percentage`+ counter +`" step="0.01" class="form-control" onkeypress="return isNumber(event);" required readonly/>
            </td>
            <td class="col-sm-1 text-center">
                <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove();">
                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                </a>
            </td>
          `;
          newRow.append(cols);
          $("#partner-product-list").append(newRow);
    }
</script>

</body>

</html>