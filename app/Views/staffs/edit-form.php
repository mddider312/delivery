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
                                <h4 class="card-title mb-4"><?= lang('Update Staff') ?></h4>

                                <form action="<?= base_url('save_update_staff/'.$staff['id']);?>" method="POST">
                                    <input type="hidden" name="_method" value="PUT" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><?= lang('Login Username') ?></label>
                                                <input class="form-control" type="text" name="username" value="<?= $staff['username']; ?>" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><?= lang('Login Password') ?></label>
                                                <input class="form-control" type="text" name="password" value="<?= $staff['password']; ?>" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><?= lang('Staff Name') ?></label>
                                                <input class="form-control" type="text" name="name" value="<?= $staff['name']; ?>" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><?= lang('Phone No.') ?></label>
                                                <input class="form-control" type="text" name="phone" value="<?= $staff['phone']; ?>" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><?= lang('Role') ?></label>
                                                <select class="form-control" name="role" value="<?= $staff['role']; ?>">
                                                    <option hidden>--Please Select--</option>
                                                    <option value="1" <?= $staff['role'] == 1 ? 'selected' : '' ?>>Staff</option>
                                                    <option value="2" <?= $staff['role'] == 2 ? 'selected' : '' ?>>Driver</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        <?= lang('Files.Update') ?>
                                    </button>
                                </form>

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

</body>

</html>