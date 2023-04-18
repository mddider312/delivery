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
                                <h4 class="card-title mb-4"><?= lang('Files.Update_Transaction') ?></h4>

                                <form action="<?= base_url('save_update_transaction/'.$transaction['id']);?>" method="POST">
                                    
                                    <input type="hidden" name="_method" value="PUT" />
                                    <input type="hidden" name="quantity_old" value="<?= $transaction['quantity'] ?>" />
                                        
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Partner Name') ?></label>
                                                <select class="form-control" name="partner_id" value="<?= $transaction['partner_id']; ?>" required>
                                                    <option hidden>--Please Select--</option>
                                                    <?php foreach($partners as $partner){ ?>
                                                        <option value="<?=  $partner['id']; ?>"<?php if ($partner['id'] == $transaction['partner_id']) echo ' selected="selected"'; ?>><?=  $partner['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Driver Name') ?></label>
                                                <select name="staff_id" class="form-control" value="<?= $transaction['staff_id']; ?>" required>
                                                    <option hidden>--Please Select--</option>
                                                    <?php foreach($drivers as $driver){ ?>
                                                        <option value="<?=  $driver['id']; ?>"<?php if ($driver['id'] == $transaction['staff_id']) echo ' selected="selected"'; ?>><?=  $driver['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Files.Product_name') ?></label>
                                                <select name="product_id" class="form-control" value="<?= $transaction['product_id']; ?>">
                                                    <?php foreach($products as $product){?>
                                                        <option value="<?=  $product['id']; ?>"<?php if ($product['id'] == $transaction['product_id']) echo ' selected="selected"'; ?>><?=  $product['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label"><?= lang('Files.Quantity') ?></label>
                                                <input type="text" pattern="[0-9]+" class="form-control" name="quantity" 
                                                value="<?= ($transaction['quantity'][0] == '-') ? ltrim($transaction['quantity'], '-') : $transaction['quantity']; ?>" placeholder="Quantity" onkeypress="return isNumber(event);">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        <?= lang('Files.Update') ?>
                                    </button>
                                </form>
                                
                                <hr>
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
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $db = db_connect();
                                                $transaction_products = $db->query("SELECT * FROM bs_transactions_products WHERE transaction_id = '$transaction[id]' AND is_deleted = 0")->getResultArray();
                                                
                                                $i = 0;
                                                foreach($transaction_products as $p) {
                                                    $i++;
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-info" onclick="generateQRcode('<?= $i ?>', '<?= $transaction['id'] ?>', '<?= $p['id'] ?>', 'view');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-primary" onclick="generateQRcode('<?= $i ?>', '<?= $transaction['id'] ?>', '<?= $p['id'] ?>', 'download');">
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
                                                            $is_sold = $p['status'] == 1 ? true : false;
                                                            
                                                            if ($is_sold) {
                                                                $order_detail = $db->query("SELECT * FROM bs_orders WHERE order_id = '$p[order_id]' LIMIT 1")->getResultArray();
                                                            }
                                                        ?>
                                                        <td class="text-center"><?= $is_sold ? $order_detail[0]['customer_name'] : "-" ?></td>
                                                        <td class="text-center"><?= $is_sold ? $order_detail[0]['customer_phone'] : "-" ?></td>
                                                        <td class="text-center"><?= $is_sold ? $p['sold_at'] : "-" ?></td>
                                                        
                                                        <?php
                                                            if ($p['order_id'] == 0) {
                                                        ?>
                                                                <td class="text-center">
                                                                    <a href="<?= base_url('delete_transaction_product/'.$transaction['id'].'/'.$p['id']) ?>" class="btn btn-danger" onclick="return confirm('Remove this transaction product from the system ?');"><i class="fa fa-trash"></i></a>
                                                                </td>
                                                        <?php
                                                            }
                                                        ?>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-secondary" onclick="qrcode('');">
                                    Generate
                                </button>


                                <a href="#" id="qrcode_download">
                                    <canvas id="qrcode"></canvas>
                                </a>
                                
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
                                <script type="text/javascript">
                                    function qrcode() {
                                        var qrcode = new QRious({
                                          element: document.getElementById("qrcode"),
                                          background: 'white',
                                          backgroundAlpha: 1,
                                          foreground: 'black',
                                          foregroundAlpha: 1,
                                          level: 'H',
                                          padding: 0,
                                          size: 256,
                                          value: "123123123"
                                        });
                                        
                                        var anchor = document.getElementById("qrcode_download");
                                        anchor.href = qrcode.toDataURL("image/png");
                                        anchor.download = "qrcode.png";
                                        anchor.click();
                                    }
                                    
                                    function isNumber(evt) {
                                        evt = (evt) ? evt : window.event;
                                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                                        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                            return false;
                                        }
                                        return true;
                                    }
                                </script>
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
            scrollY: '45vh',
            scrollCollapse: true,
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
          padding: 0,
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