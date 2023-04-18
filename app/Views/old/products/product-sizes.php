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
                                <h4 class="card-title mb-4"><?= $title ?></h4>

                                <form action="<?= base_url('update_product_size');?>" method="POST">
                                    <input type="hidden" name="_method" value="PUT" />
                                    
                                    <?= $this->include('partials/alert') ?>

                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-centered table-bordered mb-0" id="product-size-list">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Size</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($sizes as $size) {
                                                ?>
                                                        <tr>
                                                            <input name="product_size_id[]" value="<?= $size['product_size_id'] ?>" hidden>
                                                            <td class="col-sm-10">
                                                                <input type="text" name="size_name[]" class="form-control" value="<?= $size['size_name'] ?>">
                                                            </td>
                                                            <td class="col-sm-2 text-center">
                                                                <a href="<?= base_url('delete_product_size/'.$size['product_size_id']) ?>" class="ibtnDel btn btn-xs btn-danger" onclick="return confirm('Delete this size from the system ?');">
                                                                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-warning" onclick="addRow();"><i class="fa fa-plus"></i></button>
                                
                                    <br><br>
                                    
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

<script>
    var counter = parseInt(<?= COUNT($sizes) ?>);

    function addRow() {
        counter += 1;
        
          var newRow = $("<tr>");
          var cols = "";
          cols += `
            <td class="col-sm-10">
                <input type="text" name="size_name[]" class="form-control">
            </td>
            <td class="col-sm-2 text-center">
                <a type="button" class="ibtnDel btn btn-xs btn-danger" onclick="this.parentNode.parentNode.remove();">
                    <i class="fa fa-trash i_link" title="Delete" style="color:white"></i>
                </a>
            </td>
          `;
          newRow.append(cols);
          $("#product-size-list").append(newRow);
    }
</script>

</body>

</html>