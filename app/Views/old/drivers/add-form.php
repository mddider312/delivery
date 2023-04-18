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
                                <h4 class="card-title mb-4"><?= lang('Add New Order') ?></h4>

                                <form action="<?= base_url('save_order');?>" method="POST">
                                    <div class="row">
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Customer Name</label>
                                                <input type="text" class="form-control" name="customer_name" placeholder="Customer Name">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Customer Phone No.</label>
                                                <input type="text" class="form-control" name="customer_phone" placeholder="eg: 0123456789">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Partner Name</label>
                                                <select class="form-control" name="partner_id">
                                                    <option hidden>--Please Select--</option>
                                                    <?php foreach($partners as $partner){ ?>
                                                        <option value="<?=  $partner['id']; ?>"><?=  $partner['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div> 
                                        
                                        <!--
                                        <div class="col-lg-12 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Customer Address</label>
                                                <textarea class="form-control" name="customer_address"></textarea>
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                    
                                    <hr>
                                    <br>
                                    <h4 class="card-title mb-4">Order Products:</h4>
                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-centered mb-0" id="order-list">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Product</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Subtotal (RM)</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-sm-5">
                                                        <select class="form-control" name="product_id[]" onchange="assignProductDetails(1, this.value);" required>
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
                                                        <input type="text" name="price[]'" id="price1" step="0.01" class="form-control" style="border: none;" onkeyup="" onchange="" readonly/>
                                                    </td>
                                                    <td class="col-sm-2">
                                                        <input type="text" name="qty[]'" id="qty1" step="0.01" class="form-control" onkeyup="countSubTotal(1);" onchange="countSubTotal(1);" onkeypress="return isNumber(event);" required readonly/>
                                                    </td>
                                                    <td class="col-sm-2">
                                                        <input type="text" name="amount[]" id="amount1" step="0.01" data-action="sumDebit" class="form-control" style="border: none;" readonly/>
                                                    </td>
                                                    <td class="col-sm-1 text-center">
                                                        <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove(); countGrandTotal();">
                                                            <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3" style="text-align: right;">Grand Total (RM):</th>
                                                        <th>
                                                            <input type="text" name="grand_total" id="grand-total" class="form-control" style="border: none;" readonly/>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
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
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    function assignProductDetails(c, id) { // counter, product_id
        for (var i = 0; i < products.length; i++) {
            if (products[i]['id'] == id) {
                var selling_price = parseFloat(products[i]['selling_price']).toFixed(2);
                $('#price' + c).val(selling_price);
                $('#qty' + c).prop('readonly', false);
                countSubTotal(c);
                break;
            }
        }
    }
    
    function countSubTotal(c) {
        var price = parseFloat($('#price' + c).val());
        var quantity = parseFloat($('#qty' + c).val());
        var subtotal = 0;
        
        if (quantity) {
            var subtotal = (price * quantity);
        }
            
        if (isNaN(subtotal)) {
            $('#amount' + c).val((0).toFixed(2));
        } else {
            $('#amount' + c).val(subtotal.toFixed(2));
        }
            
        countGrandTotal();
    }
    
    function countGrandTotal() {
        var grand_total = 0;
        
        for (var i = 1; i <= counter; i++) {
            var ele = document.getElementById("amount" + i);
            
            if (ele) {
                var sub_total = parseFloat(ele.value);
                
                if (sub_total) {
                    grand_total += sub_total;
                }
            }
        }
        
        if (isNaN(grand_total)) {
            $('#grand-total').val((0).toFixed(2));
        } else {
            $('#grand-total').val(grand_total.toFixed(2));
        }
    }

    function addRow() {
        counter += 1;
        
          var newRow = $("<tr>");
          var cols = "";
          cols += `
            <td class="col-sm-5">
                <select class="form-control" name="product_id[]" onchange="assignProductDetails(`+counter+`, this.value);" required>
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
                <input type="text" name="price[]'" id="price`+ counter +`" step="0.01" class="form-control" onkeyup="" onchange="" style="border: none;" readonly/>
            </td>
            <td class="col-sm-2">
                <input type="text" name="qty[]'" id="qty`+ counter +`" step="0.01" class="form-control" onkeyup="countSubTotal(`+counter+`);" onchange="countSubTotal(`+counter+`);" onkeypress="return isNumber(event);" required readonly/>
            </td>
            <td class="col-sm-2">
                <input type="text" name="amount[]" id="amount`+ counter +`" step="0.01" data-action="sumDebit" class="form-control" style="border: none;" readonly/>
            </td>
            <td class="col-sm-1 text-center">
                <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove(); countGrandTotal();">
                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                </a>
            </td>
          `;
          newRow.append(cols);
          $("#order-list").append(newRow);
    }
</script>

</body>

</html>