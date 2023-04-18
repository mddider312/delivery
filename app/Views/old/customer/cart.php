<?= $this->include('partials/main') ?>

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/head-css') ?>
</head>

<?= $this->include('partials/body') ?>
    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php $this->include('partials/menu'); ?>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="page-title mb-0 font-size-18">Customer Detail</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" style="border-radius: 15px;">
                                        <div class="card-body p-0">
                                            <div class="row g-0">

                                                <div class="col-lg-8">
                                                    <div class="p-5">
                                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                                            <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                                            <h6 class="mb-0 text-muted"><?= sizeof($cartData)?> Items</h6>
                                                        </div>

                                                        <hr class="my-4">

                                                        <?php 
                                                        foreach ($cartData as $key => $value) { ?>

                                                            <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                                    <img src="<?= $value['photo'] ?>" alt="" class="img img-fluid rounded-3">
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                                    <h6 class="text-muted"><?= $value['name']; ?></h6>
                                                                    <h6 class="text-black mb-0"><?= $value['description']; ?></h6>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-xl-3 d-flex">
                                                                    <h6 class="mb-0"><?= $value['quantity']; ?> Unit</h6>

                                                                    <!-- <button class="btn btn-link px-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                                    <i class="fas fa-minus"></i>
                                                                    </button>

                                                                    <input id="form1" min="0" name="quantity" value="<?= $value['quantity']; ?>" type="number" class="form-control form-control-sm">

                                                                    <button class="btn btn-link px-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                                    <i class="fas fa-plus"></i>
                                                                    </button> -->
                                                                </div>
                                                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                                    <h6 class="mb-0">RM <?= $value['selling_price']; ?></h6>
                                                                </div>
                                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                                    <a href="<?= base_url('customer/delete_product_cart/'.$value['id']) ?>" class="text-muted"><i class="fas fa-times"></i></a>
                                                                </div>
                                                            </div>

                                                            <hr class="my-4">
                                                        <?php } ?>

                                                        <div class="pt-5">
                                                            <h6 class="mb-0"><a href="<?php echo base_url('products') ?>" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i><?= lang('Files.Back_To_Shop') ?></a></h6>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="p-5">
                                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>

                                                        <hr class="my-4">

                                                        <div class="d-flex justify-content-between mb-4">
                                                            <h5 class="text-uppercase"><?= sizeof($cartData)?> Items</h5>
                                                            <h5>RM <?= number_format((float)$total, 2, '.', '')  ?></h5>
                                                        </div>

                                                        <!-- <h5 class="text-uppercase mt-5 mb-3">Voucher Code</h5> -->
                                                        <div class="mb-5">
                                                            <!-- <div class="form-outline">
                                                                <input type="text" id="form3Examplea2" class="form-control form-control-lg">
                                                                <label class="form-label" for="form3Examplea2" style="margin-left: 0px;"></label>
                                                            </div>

                                                            <div class="d-flex justify-content-between mb-4">
                                                                <h5 class="text-uppercase">voucher name</h5>
                                                                <h5>(RM 0.00)</h5>
                                                            </div> -->

                                                            <hr class="my-4">

                                                            <div class="d-flex justify-content-between mb-5">
                                                                <h5 class="text-uppercase">Total price</h5>
                                                                <h5>RM <?= number_format((float)$total, 2, '.', '')  ?></h5>
                                                            </div>

                                                            <button type="button" class="btn btn-primary btn-block btn-lg" data-mdb-ripple-color="dark">Checkout</button>

                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="assets/js/app.js"></script>

</body>

</html>