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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-title mb-4">
                                    <div class="float-end font-size-16">
                                        <a href="/product_add" class="btn font-16 btn-primary" id="">
                                            <i class="mdi mdi-plus-circle-outline"></i> 
                                            <?= lang('Files.Add_New_Product') ?>
                                        </a>
                                    </div>
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center">#</th>
                                                <th rowspan="2" class="text-center"><?= lang('Actions') ?></th>
                                                <th rowspan="2" class="text-center"><?= lang('Photo') ?></th>
                                                <th rowspan="2" class="text-center"><?= lang('Name') ?></th>
                                                <th rowspan="2" class="text-center">Stock</th>
                                                <th rowspan="2" class="text-center"><?= lang('Cost (RM)') ?></th>
                                                <th colspan="2" class="text-center"><?= lang('Selling Price (RM)') ?></th>
                                                <th colspan="2" class="text-center"><?= lang('Warranty Month') ?></th>
                                            </tr>
                                            <tr>
                                                <th class="text-center"><?= lang('Normal') ?></th>
                                                <th class="text-center"><?= lang('Workshop') ?></th>
                                                <th class="text-center"><?= lang('Normal') ?></th>
                                                <th class="text-center"><?= lang('Workshop') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($products_data as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('view_product/'.$data['id']) ?>" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye"></i></a>
                                                            <button class="btn btn-primary btn-sm mb-1" onclick="addQuantity('<?= $data['id'] ?>');">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                            <br>
                                                            <a href="<?= base_url('update_product/'.$data['id']) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('delete_product/'.$data['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if(!empty($data['photo'])) { ?>
                                                                <img src="<?= $data['photo'] ?>" class="rounded" alt="" height="65">
                                                            <?php }else { ?>
                                                                <img src="assets/images/icons/no-camera.png" class="rounded" alt="" height="65">
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['name'] ?? "n/a"; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0" id="product-quantity-<?= $data['id'] ?>">
                                                                <?php 
                                                                    $db = db_connect();
                                                                    $result = $db->query("SELECT * FROM bs_transactions_products WHERE product_id = '$data[id]' AND partner_id = 0 AND order_id = 0 AND transaction_id = 0")->getResultArray();
                                                                    $quantity = COUNT($result);
                                                                    
                                                                    if ($quantity == 0) {
                                                                        $status = "danger";
                                                                    } else if ($quantity <= 10) {
                                                                        $status = "warning";
                                                                    } else {
                                                                        $status = "success";
                                                                    }
                                                                ?>
                                                                    <span class="badge bg-<?= $status ?>" style="font-size: 14px;"><?= $quantity ?></span>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['cost']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['selling_price']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['workshop_price']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['warranty_month']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['workshop_warranty_month']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/tasklist.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var products = <?= json_encode($products_data) ?>;

    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
            stateSave: true,
        });
    });
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    function swal(type, position, message, backdrop, timer, showConfirmButton) {
        if (timer > 0) {
            Swal.fire({
              position: position,
              icon: type,
              title: message,
              backdrop: backdrop,
              showConfirmButton: showConfirmButton,
              timer: timer,
            });
        } else {
            Swal.fire({
              position: position,
              icon: type,
              title: message,
              backdrop: backdrop,
              showConfirmButton: showConfirmButton,
            });
        }
    }
    
    function addQuantity(product_id) {
        var product_name = "";
        
        for (var i = 0; i < products.length; i++) {
            if (products[i]['id'] == product_id) {
                product_name = products[i]['name'];   
            }
        }
        
        Swal.fire({
          title: '<p class="font-size-18">Add quantity to '+ product_name +': </p>',
          html: 
          ` 
            <input name="product_id" id="product-id-hidden" value="`+ product_id +`" hidden>

            <div class="col-md-12 mb-2" style="text-align: left;">
                <label class="form-label font-size-14">Quantity <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="quantity" id="quantity" onkeypress="return isNumber(event);" value="1">
            </div>
          `,
          showCancelButton: true,
          allowOutsideClick: false,
          confirmButtonText: 'Add',
          preConfirm: function () {
            if ($('#quantity').val() < 1) {
                Swal.showValidationMessage('Invalid quantity.');
            }
              
            return new Promise(function (resolve) {
              resolve([
                $('#product-id-hidden').val(),
                $('#quantity').val(),
              ])
            })
          },
          onOpen: function () {
            $('#quantity').focus()
          }
        }).then(function (result) {
            if (result.isConfirmed) {
                var product_id = result['value'][0];
                var quantity = result['value'][1];
                
                if (product_id != "0" && quantity != "0") {
                    $.post("<?= base_url('ProductController/add_product_quantity') ?>", {
                        product_id: product_id,
                        quantity: quantity,
                    }, function(data, status){
                        if (data == "success") {
                            swal('success', 'top-start', 'Successfully added quantity to product.', false, 1500, false);
                            
                            var old_quantity = $('#product-quantity-' + product_id).text();
                            var new_quantity = parseInt(old_quantity) + parseInt(quantity);
                            var status = "";
                            
                            if (new_quantity == 0) {
                                status = "danger";
                            } else if (new_quantity <= 10) {
                                status = "warning";
                            } else {
                                status = "success";
                            }
                            
                            $('#product-quantity-' + product_id).html(`<span class="badge bg-`+ status +`" style="font-size: 14px;">`+ new_quantity +`</span>`);
                        } else {
                            swal('error', 'top-start', 'Failed to add quantity to product', false, 1500, false);
                        }
                    });
                }
            }
        }).catch(swal.noop);
    }
</script>

</body>

</html>