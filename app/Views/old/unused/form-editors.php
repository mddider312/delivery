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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Tinymce wysihtml5</h4>
                                    <p class="card-title-desc">Bootstrap-wysihtml5 is a javascript plugin that makes it
                                        easy to create simple, beautiful wysiwyg editors with the help of wysihtml5 and
                                        Twitter Bootstrap.</p>

                                    <form method="post">
                                        <textarea id="elm1" name="area"></textarea>
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

    <!--tinymce js-->
    <script src="assets/libs/tinymce/tinymce.min.js"></script>

    <!-- init js -->
    <script src="assets/js/pages/form-editor.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>