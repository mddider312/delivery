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
                                <h4 class="card-title mb-4"><?= lang('Files.Add_New_Product') ?></h4>

                                <form action="<?= base_url('save_product');?>" enctype="multipart/form-data" method="POST">

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_photo') ?></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="product_photo" name="product_photo">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Quantity') ?></label>
                                            <input class="form-control" type="text" name="quantity" placeholder="0" onkeypress="return isNumber(event, 0);">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Partner Commission Rate') ?></label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="number" name="commission" step="0.01" value="0.00" onkeypress="return isNumber(event, 1);">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_name') ?></label>
                                            <input class="form-control" type="text" name="name" placeholder="Product name">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_cost') ?></label>
                                            <input class="form-control" type="text" name="cost" placeholder="0.00" onkeypress="return isNumber(event, 1);">
                                        </div>
                                        
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?= lang('Files.Product_description') ?></label>
                                            <textarea class="form-control" name="description" rows="5"></textarea>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Brand</label>
                                            <select class="form-control" name="brand_id">
                                                <option value="0" hidden>--Please Select--</option>
                                                <?php
                                                    foreach($brands as $b) {
                                                ?>
                                                        <option value="<?= $b['product_brand_id'] ?>"><?= $b['brand_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Category</label>
                                            <select class="form-control" name="category_id">
                                                <option value="0" hidden>--Please Select--</option>
                                                <?php
                                                    foreach($categories as $c) {
                                                ?>
                                                        <option value="<?= $c['product_category_id'] ?>"><?= $c['category_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Size</label>
                                            <select class="form-control" name="size_id">
                                                <option value="0" hidden>--Please Select--</option>
                                                <?php
                                                    foreach($sizes as $s) {
                                                ?>
                                                        <option value="<?= $s['product_size_id'] ?>"><?= $s['size_name'] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Normal Selling Price (RM)') ?></label>
                                            <input class="form-control" type="text" name="selling_price" placeholder="0.00" onkeypress="return isNumber(event, 1);">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Normal Warranty Month') ?></label>
                                            <input class="form-control" type="text" name="warranty_month" placeholder="0" onkeypress="return isNumber(event, 0);">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Workshop Selling Price (RM)') ?></label>
                                            <input class="form-control" type="text" name="workshop_price" placeholder="0.00" onkeypress="return isNumber(event, 1);">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?= lang('Workshop Warranty Month') ?></label>
                                            <input class="form-control" type="text" name="workshop_warranty_month" placeholder="0" onkeypress="return isNumber(event, 0);">
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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/tasklist.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

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
</script>

</body>

</html>