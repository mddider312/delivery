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
                                        <a href="/staff_add" class="btn font-16 btn-primary" id="">
                                            <i class="mdi mdi-plus-circle-outline"></i> 
                                            <?= lang('Add New Staff') ?>
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
                                                <th class="text-center">Staff Name</th>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($staffs as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('update_staff/'.$data['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('delete_staff/'.$data['id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this staff from the system ?');"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0 text-center">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $data['name']; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0 text-center">
                                                                <?php
                                                                    switch($data['role']) {
                                                                        case 0:
                                                                            $role = "Admin";
                                                                            break;
                                                                        case 1:
                                                                            $role = "Staff";
                                                                            break;
                                                                        case 2:
                                                                            $role = "Driver";
                                                                            break;
                                                                    }
                                                                ?>
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= $role; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0 text-center">
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

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
        paging: true,
    });
});
</script>

</body>

</html>