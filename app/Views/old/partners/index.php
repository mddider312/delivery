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
                                        <a href="/partner_add" class="btn font-16 btn-primary" id="">
                                            <i class="mdi mdi-plus-circle-outline"></i> 
                                            <?= lang('Files.Add_New_Partner') ?>
                                        </a>
                                    </div>
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                <?= $this->include('partials/alert') ?>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="view_qrcode_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="view_qrcode_modal_label">QR Code</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                        <div class="row">
                                              <div class="col-12 col-md-6">
                                                  <canvas id="view_qrcode_modal_body"></canvas>
                                              </div>
                                              <div class="col-12 col-md-6 d-flex align-items-center justify-content-center" id="view_qrcode_modal_name">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center"><?= lang('Actions') ?></th>
                                                <th class="text-center"><?= lang('Files.Email') ?></th>
                                                <th class="text-center"><?= lang('Files.Partner_Name') ?></th>
                                                <th class="text-center"><?= lang('QR Code') ?></th>
                                                <th class="text-center"><?= lang('Files.Partner_Address') ?></th>
                                                <th class="text-center"><?= lang('Files.Partner_Contact') ?></th>
                                                <th class="text-center"><?= lang('Referrer') ?></th>
                                                <th class="text-center"><?= lang('Files.Commission') ?></th>
                                                <th class="text-center"><?= lang('Files.Battery_To_Collect') ?></th>
                                                <th class="text-center"><?= lang('Files.Warning') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($partners_data as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>
                                                            <a href="<?= base_url('update_partner/'.$data['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('delete_partner/'.$data['id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this partner from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['email']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['name']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info" onclick="generateQRcode('<?= $data['id'] ?>', 'view', '<?= $data['name'] ?>');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                <i class="fa fa-eye"></i>
                                                              </button>
                                                              <button class="btn btn-primary" onclick="generateQRcode('<?= $data['id'] ?>', 'download', '<?= $data['name'] ?>');">
                                                                <i class="fa fa-download"></i>
                                                              </button>
                                                              <a href="#" id="qrcode_download<?= $data['id'] ?>">
                                                                <canvas id="qrcode<?= $data['id'] ?>" hidden></canvas>
                                                              </a>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['adddress']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['contact_no']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0 text-center">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?php 
                                                                        if ($data['staff_id'] == 0) {
                                                                            echo "-";
                                                                        } else {
                                                                            foreach ($staffs as $staff) {
                                                                                if ($staff['id'] == $data['staff_id']) {
                                                                                    echo $staff['name'];
                                                                                    break;
                                                                                } 
                                                                            }
                                                                        }
                                                                    ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['commission']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['battery_to_collect']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['warning']; ?>
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