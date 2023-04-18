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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-title mb-4">
                                    <div class="float-end font-size-16">
                                        <a href="/appid_add" class="btn font-16 btn-primary" id="">
                                            <i class="mdi mdi-plus-circle-outline"></i> 
                                            <?= lang('Add New AppID') ?>
                                        </a>
                                    </div>
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                <?= $this->include('partials/alert') ?>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center"><?= lang('Actions') ?></th>
                                                <th class="text-center">AppID</th>
                                                <th class="text-center">Areas</th>
                                                <th class="text-center">Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $db = db_connect();
                                            
                                                $i = 0;
                                                foreach ($appids as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('update_appid/'.$data['appid_id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('delete_appid/'.$data['appid_id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this appID from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['appid']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?php
                                                                        $areas = $db->query("SELECT * FROM bs_appid_areas WHERE appid_id = '$data[appid_id]' AND deleted_at IS NULL")->getResultArray();
                                                                        
                                                                        $j = 0;
                                                                        foreach ($areas as $area) {
                                                                            $j++;
                                                                            
                                                                            if ($j != 1) {
                                                                                echo "<br>";
                                                                            }
                                                                            echo "$area[appid_area]";
                                                                        }
                                                                    ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['created_at']; ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
        });
    });

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
 
    function generateQRcode(partner_id, action, partner_name) {
        var qrcode = new QRious({
          element: action == "view" ? document.getElementById("view_qrcode_modal_body") : document.getElementById("qrcode" + partner_id),
          background: 'white',
          backgroundAlpha: 1,
          foreground: 'black',
          foregroundAlpha: 1,
          level: 'H',
          padding: 5,
          size: action == "view" ? 256 : 512,
          value: "<?= base_url().'/shop/' ?>" + partner_id
        });
        
        $('#view_qrcode_modal_label').text(partner_name);
        $('#view_qrcode_modal_name').text(partner_name);
        
        if (action == "download") {
            var anchor = document.getElementById("qrcode_download" + partner_id);
            anchor.href = qrcode.toDataURL("image/png");
            anchor.download = "QR_Partner_" + partner_name + ".png";
            anchor.click();
        }
    }
</script>

</body>

</html>