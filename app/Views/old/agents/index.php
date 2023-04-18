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
                                        <a href="/agent_add" class="btn font-16 btn-primary" id="">
                                            <i class="mdi mdi-plus-circle-outline"></i> 
                                            <?= lang('Add New Agent') ?>
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
                                                <th class="text-center"><?= lang('Agent Name') ?></th>
                                                <th class="text-center"><?= lang('Email') ?></th>
                                                <th class="text-center"><?= lang('QR Code') ?></th>
                                                <th class="text-center"><?= lang('Agent Contact') ?></th>
                                                <th class="text-center"><?= lang('Commission (RM)') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($agents_data as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('update_agent/'.$data['agent_id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('delete_agent/'.$data['agent_id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this agent from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['name']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['email']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-info" onclick="generateQRcode('<?= $data['agent_id'] ?>', 'view', '<?= $data['name'] ?>', '<?= $data['email'] ?>');" data-bs-toggle="modal" data-bs-target="#view_qrcode_modal">
                                                                <i class="fa fa-eye"></i>
                                                              </button>
                                                              <button class="btn btn-primary" onclick="generateQRcode('<?= $data['agent_id'] ?>', 'download', '<?= $data['name'] ?>', '<?= $data['email'] ?>');">
                                                                <i class="fa fa-download"></i>
                                                              </button>
                                                              <a href="#" id="qrcode_download<?= $data['agent_id'] ?>">
                                                                <canvas id="qrcode<?= $data['agent_id'] ?>" hidden></canvas>
                                                              </a>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['contact_no']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['commission']; ?>
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
 
    function generateQRcode(agent_id, action, agent_name, agent_email) {
        var qrcode = new QRious({
          element: action == "view" ? document.getElementById("view_qrcode_modal_body") : document.getElementById("qrcode" + agent_id),
          background: 'white',
          backgroundAlpha: 1,
          foreground: 'black',
          foregroundAlpha: 1,
          level: 'H',
          padding: 5,
          size: action == "view" ? 128 : 512,
          value: "<?= base_url().'/shop/' ?>" + agent_email
        });
        
        $('#view_qrcode_modal_label').text(agent_name + " (" + agent_email + ")");
        $('#view_qrcode_modal_name').text(agent_email);
        
        if (action == "download") {
            var anchor = document.getElementById("qrcode_download" + agent_id);
            anchor.href = qrcode.toDataURL("image/png");
            anchor.download = "QR_Agent_" + agent_name + " (" + agent_email + ").png";
            anchor.click();
        }
    }
</script>

</body>

</html>