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

                                <?= $this->include('partials/alert') ?>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center"><?= lang('Actions') ?></th>
                                                <th class="text-center"><?= lang('Agent Name') ?></th>
                                                <th class="text-center"><?= lang('Amount (RM)') ?></th>
                                                <th class="text-center"><?= lang('Status') ?></th>
                                                <th class="text-center"><?= lang('Created At') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($commissions_data as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-edit"></i>
                                                              </button>
                                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <li><a class="dropdown-item" href="#" onclick="modifyWithdrawStatus('0', '<?= $data['commission_id'] ?>');">Unpaid</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="modifyWithdrawStatus('1', '<?= $data['commission_id'] ?>');">Paid</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="modifyWithdrawStatus('2', '<?= $data['commission_id'] ?>');">Cancelled</a></li>
                                                              </ul>
                                                              <a href="<?= base_url('delete_commission_withdrawal/'.$data['commission_id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this commission request from the system ?');"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['name']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['amount']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark" id="status<?= $data['commission_id'] ?>">
                                                                    <?php
                                                                        switch($data['status']) {
                                                                            case 0:
                                                                                echo "<span class='badge bg-warning' style='font-size:14px;'>Unpaid</span>";
                                                                                break;
                                                                            case 1:
                                                                                echo "<span class='badge bg-success' style='font-size:14px;'>Paid</span>";
                                                                                break;
                                                                            case 2:
                                                                                echo "<span class='badge bg-danger' style='font-size:14px;'>Cancelled</span>";
                                                                                break;
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
<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
        });
    });
    
    function swal(type, position, message) {
        Swal.fire({
          position: position,
          icon: type,
          title: message,
          showConfirmButton: false,
          timer: 1500
        });
    }
    
    function modifyWithdrawStatus(status, commission_id) {
        $.post("<?= base_url('AgentController/modify_withdraw_status') ?>", {
            status: status,
            commission_id: commission_id,
        }, function(data, stat){
            var data = JSON.parse(data);
            
            swal(data['status'], "top-start", data['message']);
            
            if (data['status'] == "success") {
                switch (status) {
                    case "0":
                        $("#status" + commission_id).html("<span class='badge bg-warning' style='font-size:14px;'>Unpaid</span>");
                        break;
                    case "1":
                        $("#status" + commission_id).html("<span class='badge bg-success' style='font-size:14px;'>Paid</span>");
                        break;
                    case "2":
                        $("#status" + commission_id).html("<span class='badge bg-danger' style='font-size:14px;'>Cancelled</span>");
                        break;
                }
            }
        });
    }
</script>

</body>

</html>