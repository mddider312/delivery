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
                                    <div class="float-end">
                                        <a href="<?= base_url('product') ?>" class="btn btn-secondary">
                                            Back
                                        </a>
                                        <a href="<?= base_url('update_product/'.$product['id']) ?>" class="btn btn-primary">
                                            Edit
                                        </a>
                                    </div>
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="view_qrcode_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">QR Code</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                          <div class="row">
                                              <div class="col-12 col-md-6">
                                                  <canvas id="view_qrcode_modal_body"></canvas>
                                              </div>
                                              <div class="col-12 col-md-6 d-flex align-items-center justify-content-center" id="qr-tp-id">
                                              </div>
                                          </div>
                                              
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col col-md-offset-2">
                                        <div class="row d-flex justify-content-center">
                                            <div class="row d-flex justify-content-center">
                                                <img src="<?= base_url().'/'.$product['photo']; ?>" alt="<?= $product['name']; ?>" *id="cimg" style="width: auto; max-height: 500px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Name</b></div>
                                    <div class="col-md-10">:&ensp;<span id="product-name"><?= $product['name'] ?></span></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Description</b></div>
                                    <div class="col-md-10">:&ensp;<?= $product['description'] ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Commission</b></div>
                                    <div class="col-md-4">:&ensp;<?= $product['commission']." %" ?></div>
                                    <div class="col-md-2"><b>Cost</b></div>
                                    <div class="col-md-4">:&ensp;<?= "RM ".$product['cost'] ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Normal Price</b></div>
                                    <div class="col-md-4">:&ensp;<?= "RM ".$product['selling_price'] ?></div>
                                    <div class="col-md-2"><b>Normal Warranty</b></div>
                                    <div class="col-md-4">:&ensp;<?= $product['warranty_month']." Month(s)" ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Workshop Price</b></div>
                                    <div class="col-md-4">:&ensp;<?= "RM ".$product['workshop_price'] ?></div>
                                    <div class="col-md-2"><b>Workshop Warranty</b></div>
                                    <div class="col-md-4">:&ensp;<?= $product['workshop_warranty_month']." Month(s)" ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Brand</b></div>
                                    <?php
                                        $brand_name = "-";
                                        foreach ($brands as $brand) {
                                            if ($brand['product_brand_id'] == $product['brand_id']) {
                                                $brand_name = $brand['brand_name'];
                                            }
                                        }
                                    ?>
                                    <div class="col-md-4">:&ensp;<?= $brand_name ?></div>
                                    <div class="col-md-2"><b>Category</b></div>
                                    <?php
                                        $category_name = "-";
                                        foreach ($categories as $category) {
                                            if ($category['product_category_id'] == $product['category_id']) {
                                                $category_name = $category['category_name'];
                                            }
                                        }
                                    ?>
                                    <div class="col-md-4">:&ensp;<?= $category_name ?></div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Size</b></div>
                                    <?php
                                        $size_name = "-";
                                        foreach ($sizes as $size) {
                                            if ($size['product_size_id'] == $product['size_id']) {
                                                $size_name = $size['size_name'];
                                            }
                                        }
                                    ?>
                                    <div class="col-md-4">:&ensp;<?= $size_name ?></div>
                                </div>
                                
                                <div class="row mb-3">

                                </div>
                                
                                <hr>
                                <br>
                                <?= $this->include('partials/alert') ?>
                                <h4 class="card-title mb-4">Product QR Code Details: (<?= "<b>".COUNT($transaction_products)."</b> pcs total" ?>, <b><span id="partner-product-quantity"></span></b> pcs assigned to partner.)</h4>
                                <button class="btn btn-primary btn-sm mb-3" onclick="bulkDownloadQRCode();">Bulk Download</button>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">QR Code</th>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Partner</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Customer Contact</th>
                                                <th class="text-center">Sold At</th>
                                                <th class="text-center">Refund</th>
                                                <th class="text-center">Created At</th>
                                                <th class="text-center">
                                                    <!--<button class="btn btn-light btn-sm" disabled><i class="fa fa-trash"></i></button>-->
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                $j = 0; // total assigned to partner
                                                foreach($transaction_products as $p) {
                                                    $i++;
                                                    
                                                    if ($p['partner_id'] != 0) { $j++; }
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-info btn-sm" onclick="generateQRcode('<?= $i ?>', '<?= $p['id'] ?>', 'view');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-primary btn-sm" onclick="generateQRcode('<?= $i ?>', '<?= $p['id'] ?>', 'download');">
                                                                <i class="fa fa-download"></i>
                                                            </button>
                                                            <canvas id="qrcode<?= $i ?>" hidden></canvas>
                                                            <canvas id="qrcode_title<?= $i ?>" hidden></canvas>
                                                            <canvas id="qrcode_combine_title<?= $i ?>" width="4cm" height="2cm" hidden></canvas>
                                                            <a href="#" id="qrcode_download<?= $i ?>" hidden></a>
                                                            <img id="qrcode_pic<?= $i ?>">
                                                        </td>
                                                        <td class="text-center"><?= $p['id'] ?></td>
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
                                                            
                                                            if ($p['partner_id'] == 0) {
                                                                $partner_name = "-";
                                                            } else {
                                                                $partner = $db->query("SELECT * FROM bs_partners WHERE id = '$p[partner_id]'")->getResultArray();
                                                                $partner_name = $partner[0]['name'] ?? "n/a";
                                                            }
                                                        ?>
                                                        <td class="text-center"><?= $partner_name ?? "-" ?></td>
                                                        <?php
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
                                                        <td class="text-center">
                                                            <?php
                                                                /*if ($p['status'] == 1) {
                                                            ?>
                                                                    <button class="btn btn-danger btn-sm" onclick="generateQRcode('<?= $i ?>', '<?= $p['id'] ?>', 'view');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                        <i class="fa fa-undo"></i>
                                                                    </button>
                                                            <?php
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                */
                                                                echo "-";
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?= $p['created_at'] ?? "-" ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                                if ($p['order_id'] == 0) {
                                                            ?>
                                                                    <a class="btn btn-danger btn-sm" href="<?= base_url("delete_transaction_product/$product[id]/$p[id]") ?>" onclick="return confirm('Delete this product qr?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>  
                                                            <?php
                                                                } else {
                                                                    echo "-";
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
    var transaction_products = <?= json_encode($transaction_products) ?>;

    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
        });
        
        $('#partner-product-quantity').text('<?= $j ?>');
    });
    
    function generateQRcode(counter, transaction_product_id, action) {
        $("#qr-tp-id").html($('#product-name').text() + "<br>" + transaction_product_id);
        
        var qrcode = new QRious({
            element: action == "view" ? document.getElementById("view_qrcode_modal_body") : document.getElementById("qrcode" + counter),
            background: 'white',
            backgroundAlpha: 1,
            foreground: 'black',
            foregroundAlpha: 1,
            level: 'H',
            padding: 0,
            size: action == "view" ? 250 : 300,
            value: transaction_product_id
        });
        
        if (action == "download") {
            var qrcode = document.getElementById("qrcode" + counter);
            var title = document.getElementById("qrcode_title" + counter);
            title.width = 1500;
            title.height = 750;
            
            var context = title.getContext("2d");
            context.font = "40px Poppins";
            context.globalAlpha = 1.0;
            context.drawImage(qrcode, 50, 50);
            context.globalAlpha = 1;
            context.lineWidth = 1;
            context.strokeStyle = 'black';
            context.rotate(90 * (Math.PI / 180));
            context.stroke();

            var product_name = getLines(context, $('#product-name').text(), 350);
            var x = 370;
            var y = product_name.length > 4 ? -290 : -270;
            var line_count = product_name.length > 4 ? 5 : product_name.length;
            var lineheight = 45;
            
            switch (line_count) {
                case 0:
                case 1:
                    context.fillText(product_name[0], x, y + (0 * lineheight));
                    context.fillText(transaction_product_id, x, y + (1 * lineheight));
                    break;
                case 2:
                    context.fillText(product_name[0], x, y + (0 * lineheight));
                    context.fillText(product_name[1], x, y + (1 * lineheight));
                    context.fillText(transaction_product_id, x, y + (2 * lineheight));
                    break;
                case 3:
                    context.fillText(product_name[0], x, y + (0 * lineheight));
                    context.fillText(product_name[1], x, y + (1 * lineheight));
                    context.fillText(product_name[2], x, y + (2 * lineheight));
                    context.fillText(transaction_product_id, x, y + (3 * lineheight));
                    break;
                case 4:
                    context.fillText(product_name[0], x, y + (0 * lineheight));
                    context.fillText(product_name[1], x, y + (1 * lineheight));
                    context.fillText(product_name[2], x, y + (2 * lineheight));
                    context.fillText(product_name[3], x, y + (3 * lineheight));
                    context.fillText(transaction_product_id, x, y + (4 * lineheight));
                    break;
                case 5:
                    context.fillText(product_name[0], x, y + (0 * lineheight));
                    context.fillText(product_name[1], x, y + (1 * lineheight));
                    context.fillText(product_name[2], x, y + (2 * lineheight));
                    context.fillText(product_name[3], x, y + (3 * lineheight));
                    context.fillText(product_name[4], x, y + (4 * lineheight));
                    context.fillText(transaction_product_id, x, y + (5 * lineheight));
                    break;
            }
                    
            var qrcode_pic = document.getElementById("qrcode_download" + counter);
            qrcode_pic.href = title.toDataURL("image/png");
            qrcode_pic.download = "product_qrcode_" + transaction_product_id + ".png";

            var imgData = title.toDataURL("image/png");
            window.jsPDF = window.jspdf.jsPDF;
            var pdf = new window.jsPDF();
        
            pdf.addImage(imgData, 'PNG', 0, 0);
            pdf.save("ProdQR_" + $('#product-name').text() + "_" + transaction_product_id + ".pdf");
        }
    }
    
    function bulkDownloadQRCode() {
        if (transaction_products.length > 0) {
            window.jsPDF = window.jspdf.jsPDF;
            var pdf = new window.jsPDF();
            
            for (var i = 0; i < transaction_products.length; i++) {
                var qrcode = new QRious({
                    element: document.getElementById("qrcode1"),
                    background: 'white',
                    backgroundAlpha: 1,
                    foreground: 'black',
                    foregroundAlpha: 1,
                    level: 'H',
                    padding: 0,
                    size: 300,
                    value: transaction_products[i]['id']
                });
                
                var qrcode = document.getElementById("qrcode1");
                var title = document.getElementById("qrcode_title1");
                title.width = 1500;
                title.height = 750;
                
                var context = title.getContext("2d");
                context.font = "40px Poppins";
                context.globalAlpha = 1.0;
                context.drawImage(qrcode, 50, 50);
                context.globalAlpha = 1;
                context.lineWidth = 1;
                context.strokeStyle = 'black';
                context.rotate(90 * (Math.PI / 180));
                
                //context.translate(title.width/2,title.height/2);

                context.stroke();
                var product_name = getLines(context, $('#product-name').text(), 350);
                var x = 370;
                var y = product_name.length > 4 ? -290 : -270;
                var line_count = product_name.length > 4 ? 5 : product_name.length;
                var lineheight = 45;
                
                switch (line_count) {
                    case 0:
                    case 1:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (1 * lineheight));
                        break;
                    case 2:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(product_name[1], x, y + (1 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (2 * lineheight));
                        break;
                    case 3:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(product_name[1], x, y + (1 * lineheight));
                        context.fillText(product_name[2], x, y + (2 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (3 * lineheight));
                        break;
                    case 4:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(product_name[1], x, y + (1 * lineheight));
                        context.fillText(product_name[2], x, y + (2 * lineheight));
                        context.fillText(product_name[3], x, y + (3 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (4 * lineheight));
                        break;
                    case 5:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(product_name[1], x, y + (1 * lineheight));
                        context.fillText(product_name[2], x, y + (2 * lineheight));
                        context.fillText(product_name[3], x, y + (3 * lineheight));
                        context.fillText(product_name[4], x, y + (4 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (5 * lineheight));
                        break;
                }
                
                var qrcode_pic = document.getElementById("qrcode_download1");
                qrcode_pic.href = title.toDataURL("image/png");
                qrcode_pic.download = "product_qrcode_" + transaction_products[i]['id'] + ".png";
    
                var imgData = title.toDataURL("image/png");

                if (i > 0) {
                    pdf.addPage();
                }
                pdf.addImage(imgData, 'PNG', 0, 0);
            }
            
            var min = transaction_products[0]['id'];
            var max = transaction_products[transaction_products.length-1]['id'];
            
            pdf.save("BulkProdQR_" + $('#product-name').text() + "_" + min + "_" + max + ".pdf");
        }
    }
    /*
    function bulkDownloadQRCode() {
        if (transaction_products.length > 0) {
            window.jsPDF = window.jspdf.jsPDF;
            var pdf = new window.jsPDF();
            
            for (var i = 0; i < transaction_products.length; i++) {
                var qrcode = new QRious({
                    element: document.getElementById("qrcode1"),
                    background: 'white',
                    backgroundAlpha: 1,
                    foreground: 'black',
                    foregroundAlpha: 1,
                    level: 'H',
                    padding: 5,
                    size: 93,
                    value: transaction_products[i]['id']
                });
                
                var qrcode = document.getElementById("qrcode1");
                var title = document.getElementById("qrcode_title1");
                title.width = 200;
                title.height = 100;
                
                var context = title.getContext("2d");
                context.font = "10px Poppins";
                context.globalAlpha = 1.0;
                context.drawImage(qrcode, 10, 12.5);
                context.globalAlpha = 1;
                context.lineWidth = 1;
                context.strokeStyle = 'black';
                context.stroke();
                //context.strokeRect(0, 0, title.width, title.height); // border
                
                var product_name = getLines(context, $('#product-name').text(), 90);//
                var x = 90;
                var y = product_name.length > 1 ? 37.5 : 45;
                var line_count = product_name.length > 1 ? 2 : product_name.length;
                var lineheight = 15;
                
                switch (line_count) {
                    case 0:
                    case 1:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (1 * lineheight));
                        break;
                    case 2:
                        context.fillText(product_name[0], x, y + (0 * lineheight));
                        context.fillText(product_name[1] + " ...", x, y + (1 * lineheight));
                        context.fillText(transaction_products[i]['id'], x, y + (2 * lineheight));
                        break;
                }
                        
                var qrcode_pic = document.getElementById("qrcode_download1");
                qrcode_pic.href = title.toDataURL("image/png");
                qrcode_pic.download = "product_qrcode_" + transaction_products[i]['id'] + ".png";
    
                var imgData = title.toDataURL("image/png");

                if (i > 0) {
                    pdf.addPage();
                }
                pdf.addImage(imgData, 'PNG', 0, 0);
            }
            
            var min = transaction_products[0]['id'];
            var max = transaction_products[transaction_products.length-1]['id'];
            
            pdf.save("BulkProdQR_" + $('#product-name').text() + "_" + min + "_" + max + ".pdf");
        }
    }
    */
    
    function getLines(ctx, text, maxWidth) {
        var words = text.split(" ");
        var lines = [];
        var currentLine = words[0];
    
        for (var i = 1; i < words.length; i++) {
            var word = words[i];
            var width = ctx.measureText(currentLine + " " + word).width;
            if (width < maxWidth) {
                currentLine += " " + word;
            } else {
                lines.push(currentLine);
                currentLine = word;
            }
        }
        lines.push(currentLine);
        return lines;
    }
    
    function printDocument(documentId) {
        var doc = document.getElementById(documentId);
    
        //Wait until PDF is ready to print    
        if (typeof doc.print === 'undefined') {    
            setTimeout(function(){printDocument(documentId);}, 1000);
        } else {
            doc.print();
        }
    }
</script>

</body>

</html>