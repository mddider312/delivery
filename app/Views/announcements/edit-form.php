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
                                <h4 class="card-title mb-4"><?= lang('Update Announcement') ?></h4>

                                    <div class="row mb-3">
                                        <?php
                                            $data = $announcement;
                                            
                                            if ($data['photo'] != "") {
                                        ?>
                                                <div class="col col-md-offset-2">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="row d-flex justify-content-center mb-2">
                                                            <a href="<?= base_url("delete_announcement_photo/$data[announcement_id]") ?>" onclick="return confirm('Delete this announcement image?');" class="btn btn-danger btn-sm w-auto"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                        <div class="row d-flex justify-content-center">
                                                            <img src="<?= base_url('uploads/announcements/'.$data['photo']) ?>" style="width: auto; max-height: 300px;">
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                        <?php
                                            } else {
                                                echo "No Photo.";
                                            }
                                        ?>
                                    </div>
                                    
                                    <form action="<?= base_url('save_update_announcement/'.$data['announcement_id']) ?>" method="post" enctype='multipart/form-data'>
                                        <div class="row">
                                            <div class="col-lg-12 mb-2">
                                                <div class="col-lg-12 mb-2">
                                                    <label class="form-label">Announcement Title</label>
                                                    <input type="text" class="form-control" name="title" value="<?= $data['title'] ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6 mb-2">
                                                <div class="col-lg-12 mb-2">
                                                    <label class="form-label">Photo</label>
                                                    <input class="form-control" type="file" id="images" name="photo" accept="image/png, image/jpeg, image/jpg, image/webp" <?= $data['photo'] == "" ? "required" : "" ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-2">
                                                <div class="col-lg-12 mb-2">
                                                    <label class="form-label">Announcement Content</label>
                                                    <textarea class="form-control" name="content" onkeyup="textAreaAdjust(this);" id="content-textarea"><?= $data['content'] ?></textarea>
                                                </div>
                                            </div>
                                        </div><!--end row-->

                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button class="btn btn-secondary" onclick="history.back()">Back</button>
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
    $(document).ready(function(){
        $('#content-textarea').keyup();
    });

    function textAreaAdjust(element) {
        element.style.height = "1px";
        element.style.height = (25+element.scrollHeight)+"px";
    }
</script>
</body>

</html>