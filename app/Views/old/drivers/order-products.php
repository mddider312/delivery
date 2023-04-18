<?= $this->include('partials/main') ?>

<head>

    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

</head>

<style>
    .otp-table td.fit, .otp-table th.fit {
        white-space: nowrap;
        width: 1%;
    }

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
                                <?php $data = $order_data[0]; ?>
                                
                                <div class="invoice-title mb-4">
                                    <div class="float-end">
                                        <a href="<?= base_url('order') ?>" class="btn btn-secondary">
                                            Back
                                        </a>
                                        <!--
                                        <a href="<?= base_url('update_order/'.$data['order_id']) ?>" class="btn btn-primary">
                                            Edit
                                        </a>
                                        -->
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
                                  <div class="col-md-2"><b>Customer</b></div>
                                  <div class="col-md-4">:&ensp;<?= $data['customer_name'] ?></div>
                                  <div class="col-md-2"><b>Contact No.</b></div>
                                  <div class="col-md-4">:&ensp;<?=  $data['customer_phone'] ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                  <div class="col-md-2"><b>Address</b></div>
                                  <div class="col-md-4">:&ensp;<?= $data['customer_address'] ?></div>
                                  <div class="col-md-2"><b>No. Plate</b></div>
                                  <div class="col-md-4">:&ensp;<?=  $data['license_plate'] ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                  <div class="col-md-2"><b>Partner</b></div>
                                  <div class="col-md-4">:&ensp;<?= $data['name'] ?></div>
                                    
                                  <div class="col-md-2"><b>Commission</b></div>
                                  <div class="col-md-4">:&ensp;<?= "RM 0.00" ?></div>
                                </div>
                                
                                <div class="row mb-3">
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
                                  <div class="col-md-2"><b>Status</b></div>
                                  <div class="col-md-4">:&ensp;
                                    <select class="form-control w-auto btn btn-<?= $btn ?> btn-sm font-size-14" id="order-status-btn-<?= $data['order_id'] ?>" value="<?= $data['order_id'] ?>" onchange="updateOrderStatus('<?= $data['order_id'] ?>', this.value);">
                                        <option class="white_bg" value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Pending</option>
                                        <option class="white_bg" value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Done</option>
                                        <option class="white_bg" value="2" <?= $data['status'] == 2 ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                  </div>
                                    
                                  <div class="col-md-2"><b>Final Total</b></div>
                                  <div class="col-md-4">:&ensp;<?= "RM ".$data['final_total'] ?></div>
                                </div>

                                
                                
                                <hr>
                                <br>
                                <?= $this->include('partials/alert') ?>
                                
                                <?php
                                    $db = db_connect();
                                    $order_products = $db->query("SELECT * FROM bs_orders_products WHERE order_id = '$data[order_id]'")->getResultArray();
                                ?>
                                <h4 class="card-title mb-4">Order Product Details: (<?= COUNT($order_products) ?> Items)</h4>
                                <div class="table-responsive">
                                  <table class="table table-nowrap table-centered mb-0">
                                    <thead>
                                      <tr>
                                        <th style="text-align: right;">#</th>
                                        <th class="text-center">Product Name</th>
                                        <!--
                                        <th class="text-center">QR Code</th>
                                        -->
                                        <th class="text-center">Price (RM)</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Subtotal (RM)</th>
                                        <!--
                                        <th class="text-center">Actions</th>
                                        -->
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $i = 0;
                                        foreach($order_product_data as $p) {
                                          $i++;
                                      ?>
                                      <tr>
                                        <td class="text-center"><i class="fa fa-plus" onclick="viewProductBarcode('<?= $i ?>', this)"></i>&emsp;<?= $i ?></td>
                                        <td class="text-left"><?= $p['name'] ?? "-" ?></td>
                                        <td style="text-align: right;"><?= $p['price'] ?? "-" ?></td>
                                        <td class="text-center"><?= $p['quantity'] ?? "-" ?></td>
                                        <td style="text-align: right;"><?= $p['subtotal'] ?? "-" ?></td>
                                        <!--
                                        <td class="text-center">
                                            <a href="<?= base_url('delete_order_product/'.$data['order_id'].'/'.$p['order_product_id']) ?>" class="btn btn-danger" onclick="return confirm('Remove this transaction product from the system ?');"><i class="fa fa-trash"></i></a>
                                        </td>
                                        -->
                                      </tr>
                                      <tr class="d-none" id="row<?= $i ?>">
                                        <td class="bg-light" colspan="5">
                                          <div class="card mb-0">
                                            <div class="card-body" style="padding: 0px 0px 30px 0px;">
                                              <table class="table table-sm table-bordered otp-table mb-0">
                                                <thead>
                                                  <tr>
                                                    <th style="text-align:right;">#</th>
                                                    <th class="text-center">QR Code</th>
                                                    <th class="text-center">Warranty Month</th>
                                                    <th class="text-center">Warranty Start Date</th>
                                                    <th class="text-center">Warranty End Date</th>
                                                    <th class="text-center">Claim</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php
                                                    $order_transaction_products = $db->query("SELECT * FROM bs_orders_transactions_products WHERE order_id = '$data[order_id]' AND product_id = '$p[product_id]'")->getResultArray();
                                                        
                                                    $j = 0;
                                                    foreach ($order_transaction_products as $otp) {
                                                      $j++;
                                                  ?>
                                                      <tr>
                                                        <td style="text-align:right;"><?= $j ?></td>
                                                        <td class="text-center">
                                                          <?php
                                                            if ($otp['transaction_product_id'] != 0) {
                                                          ?>
                                                              <button class="btn btn-info btn-sm" onclick="generateQRcode('<?= $otp['transaction_product_id'] ?>', 'view');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                <i class="fa fa-eye"></i>
                                                              </button>
                                                              <button class="btn btn-primary btn-sm" onclick="generateQRcode('<?= $otp['transaction_product_id'] ?>', 'download');">
                                                                <i class="fa fa-download"></i>
                                                              </button>
                                                              <a href="#" id="qrcode_download<?= $otp['transaction_product_id'] ?>">
                                                                <canvas id="qrcode<?= $otp['transaction_product_id'] ?>" hidden></canvas>
                                                              </a>
                                                          <?php
                                                            } else {
                                                              echo "-";
                                                            }
                                                          ?>
                                                        </td>
                                                        <td class="text-center"><?= $otp['warranty_month'] == 0 ? "-" : $otp['warranty_month'] ?></td>
                                                        <td class="text-center"><?= $otp['warranty_start_date'] ?? "-" ?></td>
                                                        <td class="text-center"><?= $otp['warranty_end_date'] ?? "-" ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                                if ($otp['claim_at'] == null) {
                                                                    echo "-";
                                                                } else {
                                                            ?>
                                                                    <button class="btn btn-danger btn-sm" onclick="showClaimModal('<?= $otp['transaction_product_id'] ?>', 'view');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                        <i class="fa fa-exchange"></i>
                                                                    </button>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
                                                      </tr>
                                                  <?php
                                                    }
                                                  ?>
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </td>
                                      </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <th colspan="4" style="text-align:right;">Grand Total (RM)</th>
                                        <th style="text-align:right;"><?= $data['grand_total'] ?></th>
                                      </tr>
                                      
                                      <?php
                                        if ($data['voucher_code'] != "") {
                                      ?>
                                            <tr>
                                                <th colspan="4" style="text-align:right;">Voucher Discount (RM)<br><span style='font-size: 10px;'><?= $data['voucher_code'] ?></span></th>
                                                <th style="text-align:right;"><?= "- ".$data['voucher_discount'] ?></th>
                                            </tr>
                                      <?php
                                        }
                                      ?>
                                      
                                      <?php
                                        if ($data['trade_in_discount'] != 0.00) {
                                            $trade_ins = $db->query("SELECT * FROM bs_trade_ins WHERE order_id = '$data[order_id]'")->getResultArray();
                                            
                                            if (COUNT($trade_ins) > 0) {
                                                $trade_in_id = $trade_ins[0]['trade_in_id'];
                                                $items = $db->query("SELECT * FROM bs_trade_ins_items WHERE trade_in_id = '$trade_in_id'")->getResultArray();
                                            }
                                      ?>
                                            <tr>
                                                <th colspan="4" style="text-align:right;">
                                                    Trade-In Discount (RM)
                                                    <?php
                                                        if (COUNT($items) > 0) {
                                                            echo "<span style='font-size: 10px;'>";
                                                            
                                                            foreach($items as $item) {
                                                                $types = $db->query("SELECT * FROM bs_trade_ins_types WHERE trade_in_type_id = '$item[trade_in_type_id]'")->getResultArray();
                                                                $type = $types[0]['type'] ?? "n/a";
                                                                
                                                                echo "<br>$type x $item[quantity] = $item[sub_total]";
                                                            }
                                                            
                                                            echo "</span>";
                                                        }
                                                    ?>
                                                </th>
                                                <th style="text-align:right;"><?= "- ".$data['trade_in_discount'] ?></th>
                                            </tr>
                                      <?php
                                        }
                                      ?>
                                      
                                          
                                      <tr>
                                        <th colspan="4" style="text-align:right;">Final Total (RM)</th>
                                        <th style="text-align:right;"><?= $data['final_total'] ?></th>
                                      </tr>
                                    </tfoot>
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
<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function viewProductBarcode(counter, ele) {
        var x = document.getElementById('row' + counter);
        
        if (x.className == "d-none") {
            x.className = "";
            ele.className = "fa fa-minus";
        } else {
            x.className = "d-none";
            ele.className = "fa fa-plus";
        }
    }
 
    function generateQRcode(transaction_product_id, action) {
        var qrcode = new QRious({
          element: action == "view" ? document.getElementById("view_qrcode_modal_body") : document.getElementById("qrcode" + transaction_product_id),
          background: 'white',
          backgroundAlpha: 1,
          foreground: 'black',
          foregroundAlpha: 1,
          level: 'H',
          padding: 0,
          size: action == "view" ? 256 : 512,
          value: transaction_product_id
        });
        
        if (action == "download") {
            var anchor = document.getElementById("qrcode_download" + transaction_product_id);
            anchor.href = qrcode.toDataURL("image/png");
            anchor.download = "tp_qrcode_" + transaction_product_id + ".png";
            anchor.click();
        }
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