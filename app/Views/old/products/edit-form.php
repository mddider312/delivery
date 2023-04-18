<?= $this->include('partials/main') ?>

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/head-css') ?>
</head>

<?= $this->include('partials/body') ?>
<div class="container-fluid">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?><div class="main-content">
            <div class="page-content">
                <?= $page_title ?>
                <div class="row align-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"><?= lang('Files.Update_Product') ?></h4>

                                <form action="<?= base_url('save_update_product/'.$product['id']);?>" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="_method" value="PUT" />
                                    
                                    <div class="row">
                                        <div class="row mb-3">
                                            <div class="col col-md-offset-2">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="row d-flex justify-content-center">
                                                        <img src="<?= base_url().'/'.$product['photo']; ?>" alt="<?= $product['name']; ?>" *id="cimg" style="width: auto; max-height: 500px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_photo') ?></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="product_photo" name="product_photo">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Available Quantity') ?></label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="text" placeholder="0" id="quantity-input" onkeypress="return isNumber(event, 0);" value="<?= $quantity ?>" disabled>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="addQuantity('<?= $product['id'] ?>');">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Partner Commission Rate') ?></label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="number" name="commission" step="0.01" onkeypress="return isNumber(event, 1);" value="<?= $product['commission'] ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_name') ?></label>
                                            <input class="form-control" type="text" name="name" placeholder="Product name" value="<?= $product['name']; ?>"id="name-input">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_cost') ?></label>
                                            <input class="form-control" type="text" name="cost" placeholder="0.00" onkeypress="return isNumber(event, 1);" value="<?= $product['cost']; ?>">
                                        </div>
                                        
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_description') ?></label>
                                            <textarea class="form-control" name="description" rows="5"><?= $product['description']; ?></textarea>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Brand</label>
                                            <select class="form-control" name="brand_id" value="<?= $product['brand_id'] ?>">
                                                <option value="0" hidden>--Please Select--</option>
                                                <?php
                                                    foreach($brands as $b) {
                                                ?>
                                                        <option value="<?= $b['product_brand_id'] ?>" <?= $b['product_brand_id'] == $product['brand_id'] ? 'selected' : '' ?>><?= $b['brand_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Category</label>
                                            <select class="form-control" name="category_id" value="<?= $product['category_id'] ?>">
                                                <option value="0" hidden>--Please Select--</option>
                                                <?php
                                                    foreach($categories as $c) {
                                                ?>
                                                        <option value="<?= $c['product_category_id'] ?>" <?= $c['product_category_id'] == $product['category_id'] ? 'selected' : '' ?>><?= $c['category_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Size</label>
                                            <select class="form-control" name="size_id" value="<?= $product['size_id'] ?>">
                                                <option value="0" hidden>--Please Select--</option>
                                                <?php
                                                    foreach($sizes as $s) {
                                                ?>
                                                        <option value="<?= $s['product_size_id'] ?>" <?= $s['product_size_id'] == $product['size_id'] ? 'selected' : '' ?>><?= $s['size_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Normal Selling Price (RM)') ?></label>
                                            <input class="form-control" type="text" name="selling_price" placeholder="0.00" onkeypress="return isNumber(event, 1);" value="<?= $product['selling_price']; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Normal Warranty Month') ?></label>
                                            <input class="form-control" type="text" name="warranty_month" placeholder="0" onkeypress="return isNumber(event, 0);" value="<?= $product['warranty_month']; ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Workshop Selling Price (RM)') ?></label>
                                            <input class="form-control" type="text" name="workshop_price" placeholder="0.00" onkeypress="return isNumber(event, 1);" value="<?= $product['workshop_price']; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Workshop Warranty Month') ?></label>
                                            <input class="form-control" type="text" name="workshop_warranty_month" placeholder="0" onkeypress="return isNumber(event, 0);" value="<?= $product['workshop_warranty_month']; ?>">
                                        </div>
                                    </div>

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
<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function isNumber(evt, type) { // type 0 = no decimal, type 1 = with decimal
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46 && type == 1) {
          return true;  
        } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
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
        var product_name = $('#name-input').val();
        
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
                            
                            var old_quantity = $('#quantity-input').val();
                            var new_quantity = parseInt(old_quantity) + parseInt(quantity);
                            $('#quantity-input').val(new_quantity);
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