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
                                <?php $data = $transactions_data[0]; ?>
                                
                                <div class="invoice-title mb-4">
                                    <div class="float-end">
                                        <a href="<?= base_url('transaction') ?>" class="btn btn-secondary">
                                            Back
                                        </a>
                                        <a href="<?= base_url('update_transaction/'.$data['transaction_id']) ?>" class="btn btn-primary">
                                            Edit
                                        </a>
                                    </div>
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="view_qrcode_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">QR Code</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                        <canvas id="view_qrcode_modal_body"></canvas>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Partner</b></div>
                                    <div class="col-md-4">:&ensp;<?=  $data['partner_name'] ?></div>
                                    <div class="col-md-2"><b>Driver</b></div>
                                    <?php  
                                        $db = db_connect();
                                        $result = $db->query("SELECT * FROM bs_staffs WHERE id = '$data[driver_id]'")->getResultArray();
                                        $driver_name = $result[0]['name'] ?? "-";
                                    ?>
                                    <div class="col-md-4">:&ensp;<?= $driver_name; ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Stock Name</b></div>
                                    <div class="col-md-4">:&ensp;<?= $data['product_name'] ?></div>
                                    <div class="col-md-2"><b>Quantity</b></div>
                                    <div class="col-md-4">:&ensp;<?=  ($data['quantity'] >= 0)?$data['quantity']:''; ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <?php 
                                        switch($data['status']) {
                                            case 0:
                                                $status = "Haven't accept";
                                                $color = "warning";
                                                break;
                                            case 1:
                                                $status = "Accepted";
                                                $color = "success";
                                                break;
                                            case 2:
                                                $status = "Rejected";
                                                $color = "danger";
                                                break;
                                        }
                                    ?>
                                    
                                    <div class="col-md-2"><b>Status</b></div>
                                    <div class="col-md-4">:&ensp;<?php echo "<span class='badge bg-".$color." p-2 font-size-14'>".$status."</span>"; ?></div>
                                    
                                    <?php
                                        if ($data['status'] == 2) {
                                    ?>
                                            <div class="col-md-2"><b>Reason</b></div>
                                            <div class="col-md-4">:&ensp;<?= $data['reject_reason'] ?></div>
                                    <?php
                                        }
                                    ?>
                                </div>
                                
                                <hr>
                                <br>
                                <?= $this->include('partials/alert') ?>
                                <h4 class="card-title mb-4">Transaction Product Details:</h4>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">QR Code</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Customer Contact</th>
                                                <th class="text-center">Sold At</th>
                                                <!--
                                                <th class="text-center">Actions</th>
                                                -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $db = db_connect();
                                                $transaction_products = $db->query("SELECT * FROM bs_transactions_products WHERE transaction_id = '$data[transaction_id]' AND is_deleted = 0")->getResultArray();
                                                
                                                $i = 0;
                                                foreach($transaction_products as $p) {
                                                    $i++;
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-info" onclick="generateQRcode('<?= $i ?>', '<?= $data['transaction_id'] ?>', '<?= $p['id'] ?>', 'view');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-primary" onclick="generateQRcode('<?= $i ?>', '<?= $data['transaction_id'] ?>', '<?= $p['id'] ?>', 'download');">
                                                                <i class="fa fa-download"></i>
                                                            </button>
                                                            <a href="#" id="qrcode_download<?= $i ?>">
                                                                <canvas id="qrcode<?= $i ?>" hidden></canvas>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                switch($p['status']) {
                                                                    case 0:
                                                                        $status = "Not Sold";
                                                                        break;
                                                                    case 1:
                                                                        $status = "Sold";
                                                                        break;
                                                                    case 2:
                                                                        $status = "Rejected";
                                                                        break;
                                                                }
                                                                
                                                                echo $status;
                                                            ?>
                                                        </td>
                                                        <?php
                                                            $db = db_connect();
                                                            
                                                            if ($p['status'] == 1) {
                                                                $cust = $db->query("SELECT * FROM bs_orders WHERE order_id = '$p[order_id]'")->getResultArray();
                                                                $cust_name = $cust[0]['customer_name'] ?? "n/a";
                                                                $cust_phone = $cust[0]['customer_phone'] ?? "n/a";
                                                            } else {
                                                                $cust_name = "-";
                                                                $cust_phone = "-";
                                                            }
                                                        ?>
                                                        <td class="text-center"><?= $cust_name ?? "-" ?></td>
                                                        <td class="text-center"><?= $cust_phone ?? "-" ?></td>
                                                        <td class="text-center"><?= $p['sold_at'] ?? "-" ?></td>
                                                        <!--
                                                        <td class="text-center">
                                                            <a href="<?= base_url('delete_transaction_product/'.$data['transaction_id'].'/'.$p['id']) ?>" class="btn btn-danger" onclick="return confirm('Remove this transaction product from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
        });
        
        /*
        var transaction_products = <?= json_encode($transaction_products) ?>;
        
        for (var i = 0; i < transaction_products.length; i++) {
            generateQRcode(i+1, transaction_products[i]['id']);
        }
        */
    });

    function generateQRcode(counter, transaction_id, transaction_product_id, action) {
        var qrcode = new QRious({
          element: action == "view" ? document.getElementById("view_qrcode_modal_body") : document.getElementById("qrcode" + counter),
          background: 'white',
          backgroundAlpha: 1,
          foreground: 'black',
          foregroundAlpha: 1,
          level: 'H',
          padding: 5,
          size: action == "view" ? 256 : 512,
          value: transaction_product_id
        });
        
        if (action == "download") {
            var anchor = document.getElementById("qrcode_download" + counter);
            anchor.href = qrcode.toDataURL("image/png");
            anchor.download = "tp_qrcode_" + transaction_id + "_" + transaction_product_id + ".png";
            anchor.click();
        }
    }
</script>

</body>

</html>