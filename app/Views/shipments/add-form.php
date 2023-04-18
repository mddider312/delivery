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
                                
                                <form action="<?= $shipment_type == "pickup" ? base_url('save_pickup') : base_url('save_dropoff');?>" method="post" enctype='multipart/form-data'>
                                    <input type="text" class="form-control" name="shipment_type" value="<?= $shipment_type ?>" hidden>
                                    <div class="row">
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Shipment No.</label>
                                                <input type="text" class="form-control" name="shipment_no" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Driver</label>
                                                <select class="form-control" name="driver">
                                                    <option hidden>-- SELECT --</option>
                                                    <?php
                                                        foreach ($drivers as $d) {
                                                    ?>
                                                            <option value="<?= $d['id'] ?>"><?= $d['name']." (".$d['phone'].")" ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Shipment Type</label>
                                                <select class="form-control" name="shipment_group">
                                                    <option hidden>-- SELECT --</option>
                                                    <option value="BS">BS</option>
                                                    <option value="SE">SE</option>
                                                    <option value="EHU">EHU</option>
                                                    <option value="BS/SE">BS/SE</option>
                                                    <option value="BYSEA">BYSEA</option>
                                                    <option value="DOCKET">DOCKET</option>
                                                    <option value="RETURN CARGO">RETURN CARGO</option>
                                                    <option value="ECOMMERCE DELIVERY">ECOMMERCE DELIVERY</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Shipment Weight (KG)</label>
                                                <input type="text" class="form-control" name="weight" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Driver Commission (RM)</label>
                                                <input type="text" class="form-control" name="driver_commission" required>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <label class="form-label"><b>Sender Details:</b></label>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="sender_name" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" name="sender_email">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Phone No.</label>
                                                <input type="text" class="form-control" name="sender_phone" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Country</label>
                                                <select class="form-control" name="sender_country">
                                                    <option hidden>-- SELECT --</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="TH">Thailand</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Address Line 1</label>
                                                <input type="text" class="form-control" name="sender_address_line1" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Address Line 2 (optional)</label>
                                                <input type="text" class="form-control" name="sender_address_line2">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Postcode</label>
                                                <input type="text" class="form-control" name="sender_postcode">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="sender_city">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control" name="sender_state">
                                            </div>
                                        </div>
                                        
                                        <hr>
                                         
                                        <label class="form-label"><b>Receiver Details:</b></label>

                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="receiver_name" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" name="receiver_email">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Phone No.</label>
                                                <input type="text" class="form-control" name="receiver_phone" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Country</label>
                                                <select class="form-control" name="receiver_country">
                                                    <option hidden>-- SELECT --</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="TH">Thailand</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Address Line 1</label>
                                                <input type="text" class="form-control" name="receiver_address_line1">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Address Line 2 (optional)</label>
                                                <input type="text" class="form-control" name="receiver_address_line2">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">Postcode</label>
                                                <input type="text" class="form-control" name="receiver_postcode">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="receiver_city">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                            <div class="col-lg-12 mb-2">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control" name="receiver_state">
                                            </div>
                                        </div>
                                    </div><!--end row-->
                                    
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
    function textAreaAdjust(element) {
        element.style.height = "1px";
        element.style.height = (25+element.scrollHeight)+"px";
    }
</script>
</body>

</html>