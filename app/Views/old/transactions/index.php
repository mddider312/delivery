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
                                    <div class="float-end font-size-16">
                                        <a href="/transaction_add" class="btn font-16 btn-primary" id="">
                                            <i class="mdi mdi-plus-circle-outline"></i> 
                                            <?= lang('Files.Add_New_Transaction') ?>
                                        </a>
                                    </div>
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Actions</th>
                                                <th class="text-center"><?= lang('Stock Name') ?></th>
                                                <th class="text-center">Partner</th>
                                                <th class="text-center">Driver</th>
                                                <th class="text-center"><?= lang('Quantity') ?></th>
                                                <th class="text-center"><?= lang('Status') ?></th>
                                                <th class="text-center"><?= lang('Files.Date') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($transactions_data as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>
                                                            <a href="<?= base_url('transaction_product_list/'.$data['transaction_id']) ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                                            <a href="<?= base_url('update_transaction/'.$data['transaction_id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('delete_transaction/'.$data['transaction_id']) ?>" class="btn btn-danger" onclick="return confirm('Remove this transaction from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  (!empty($data['product']))?$data['product']['name']:''; ?>
                                                            </h5> 
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?=  $data['name'] ?>
                                                            </h5> 
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <?php  
                                                                    $db = db_connect();
                                                                    
                                                                    if ($data['driver_id'] == 0) {
                                                                        echo "-";
                                                                    } else {
                                                                        $result = $db->query("SELECT * FROM bs_staffs WHERE id = '$data[driver_id]'")->getResultArray();
                                                                        $driver_name = $result[0]['name'];
                                                                        
                                                                        echo $driver_name;
                                                                    }
                                                                ?>
                                                            </h5> 
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?=  ($data['quantity'] >= 0)?$data['quantity']:''; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
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
                                                        
                                                                echo "<span class='badge bg-".$color." p-2 font-size-14'>".$status."</span>";
                                                                
                                                                if ($data['status'] == 2) {
                                                            ?>
                                                                    <span class="badge bg-info p-2 font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $data['reject_reason'] ?>">
                                                                        Reason
                                                                    </span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= date('Y-m-d', strtotime($data['transaction_date'])); ?>
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

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
        paging: true,
    });
});
</script>

</body>

</html>