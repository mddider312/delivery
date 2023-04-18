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
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('customer/cart')?>">view my cart</a></li> 
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">

                    <div class="card rounded circle">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="fw-bold mb-0 text-black">Customer Detail</h1>
                                </div>
                            </div>
                            <hr class="my-4">
                            <form action="<?= base_url('customer/add_customer');?>" method="POST">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Name</strong></label>
                                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="contact" class="form-label"><strong>Contact No</strong></label>
                                        <input type="text" name="contact" class="form-control" placeholder="contact no" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="address" class="form-label">
                                                <strong>Address</strong>
                                            </label>
                                            <input type="text" name="address_line_1" class="form-control mb-1" placeholder="Address Line 1" required>
                                            <input type="text" name="address_line_2" class="form-control" placeholder="Address Line 2 (optional)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="state provincce" class="form-label"><strong>State</strong></label>
                                        <input type="text" name="state" class="form-control" placeholder="state" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="" class="form-label"><strong>Postal Code</strong></label>
                                        <input type="text" name="postal_code" class="form-control" placeholder="postal code" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
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