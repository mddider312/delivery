<?= $this->include('partials/main') ?>

<head>

    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

</head>

<style>
    .white_bg {
        background-color: white;
        color:black;
    }
</style>

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
 
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0 table-sm">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center">#</th>
                                                <th rowspan="2" class="text-center">Actions</th>
                                                <th rowspan="2" class="text-center">Status</th>
                                                <th colspan="4" class="text-center">Customer</th>
                                                <th rowspan="2" class="text-center">Partner<br>Name</th>
                                                <!--
                                                <th rowspan="2" class="text-center">Grand<br>Total<br>(RM)</th>
                                                <th rowspan="2" class="text-center">Voucher<br>Discount<br>(RM)</th>
                                                <th rowspan="2" class="text-center">Trade-In<br>Discount<br>(RM)</th>
                                                -->
                                                <th rowspan="2" class="text-center">Final<br>Total<br>(RM)</th>
                                                <th rowspan="2" class="text-center">Created At</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Contact No.</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">No. Plate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($orders_data as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('order_product_list/'.$data['order_id']) ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php 
                                                                switch($data['status']) {
                                                                    case 0:
                                                                        $btn = "warning";
                                                                        break;
                                                                    case 1:
                                                                        $btn = "success";
                                                                        break;
                                                                    case 2:
                                                                        $btn = "danger";
                                                                        break;
                                                                }
                                                            ?>

                                                            <select class="form-control w-auto btn btn-<?= $btn ?> btn-sm font-size-14" id="order-status-btn-<?= $data['order_id'] ?>" value="<?= $data['order_id'] ?>" onchange="updateOrderStatus('<?= $data['order_id'] ?>', this.value);">
                                                                <option class="white_bg" value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Pending</option>
                                                                <option class="white_bg" value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Done</option>
                                                            </select>
                                                        </td>
                                                        
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  $data['customer_name'] ?>
                                                            </h5> 
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  $data['customer_phone'] ?>
                                                            </h5> 
                                                        </td>

                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  $data['customer_address'] ?>
                                                            </h5> 
                                                        </td>
                                                        
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  $data['license_plate'] ?>
                                                            </h5> 
                                                        </td>
                                                        
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  $data['name'] ?>
                                                            </h5> 
                                                        </td>
                                                        
                                                        <!--
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0" style="text-align: right;">
                                                                <?= $data['grand_total'] ?>
                                                            </h5> 
                                                        </td>
                                                        
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0" style="text-align: right;">
                                                                <?= $data['voucher_discount'] == 0.00 ? "-" : "-".$data['voucher_discount'] ?>
                                                            </h5> 
                                                        </td>
                                                        
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0" style="text-align: right;">
                                                                <?= $data['trade_in_discount'] == 0.00 ? "-" : "-".$data['trade_in_discount'] ?>
                                                            </h5> 
                                                        </td>
                                                        -->
                                                        
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0" style="text-align: right;">
                                                                <?=  $data['final_total'] ?>
                                                            </h5> 
                                                        </td>
                                                        
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= date('Y-m-d', strtotime($data['order_date'])); ?>
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
    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
        });
    });
    
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
    
    function updateOrderStatus(order_id, order_status) {
        $.post("<?= base_url('OrderController/update_order_status') ?>", {
            order_id: order_id,
            order_status: order_status,
        }, function(data, status){
            if (data == "success") {
                switch (order_status) {
                    case "0":
                        $('#order-status-btn-' + order_id).attr('class', 'form-control w-auto btn btn-warning btn-sm font-size-14');
                        break;
                    case "1":
                        $('#order-status-btn-' + order_id).attr('class', 'form-control w-auto btn btn-success btn-sm font-size-14');
                        break;
                    case "2":
                        $('#order-status-btn-' + order_id).attr('class', 'form-control w-auto btn btn-danger btn-sm font-size-14');
                        break;
                }
                
                swal("success", "top-start", "Successfully changed order status.", false, 1000, false);
            } else {
                swal("error", "top-start", "Failed to change order status.", false, 1000, false);
            }
        });
    }
</script>

</body>

</html>