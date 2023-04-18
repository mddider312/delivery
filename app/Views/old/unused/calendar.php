<?= $this->include('partials/main') ?>

    <head>

        <?= $title_meta ?>
        
        <!-- Plugin css -->
        <link href="assets/css/main.css" rel="stylesheet" type="text/css" />

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

                            <div class="row mb-4">
                                <div class="col-lg-3">
                                    <div class="card mb-0  h-100">
                                        <div class="card-body">
                                            <button class="btn font-16 btn-primary w-100" id="btn-new-event"><i
                                                    class="mdi mdi-plus-circle-outline"></i> Create
                                                New Event</button>


                                            <div id="external-events" class="m-t-20">
                                                <br>
                                                <p class="text-muted">Drag and drop your event or click in the calendar
                                                </p>
                                                <div class="external-event fc-event bg-success" data-class="bg-success">
                                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>New
                                                    Event Planning
                                                </div>
                                                <div class="external-event fc-event bg-info" data-class="bg-info">
                                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Meeting
                                                </div>
                                                <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                                    <i
                                                        class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generating
                                                    Reports
                                                </div>
                                                <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Create
                                                    New theme
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-lg-9">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->

                            </div>

                            <div style='clear:both'></div>

                            <!-- Add New Event MODAL -->
                            <div class="modal fade" id="event-modal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h5 class="modal-title" id="modal-title">Event</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Event Name</label>
                                                            <input class="form-control" placeholder="Insert Event Name"
                                                                type="text" name="title" id="event-title" required
                                                                value="" />
                                                            <div class="invalid-feedback">Please provide a valid event
                                                                name</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Category</label>
                                                            <select class="form-select" name="category" id="event-category">
                                                                <option value="bg-danger" selected>Danger</option>
                                                                <option value="bg-success">Success</option>
                                                                <option value="bg-primary">Primary</option>
                                                                <option value="bg-info">Info</option>
                                                                <option value="bg-dark">Dark</option>
                                                                <option value="bg-warning">Warning</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a valid event
                                                                category</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            id="btn-delete-event">Delete</button>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button type="button" class="btn btn-light me-1"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success"
                                                            id="btn-save-event">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div> <!-- end modal-content-->
                                </div> <!-- end modal dialog-->
                            </div>
                            <!-- end modal-->
                        </div>
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

    <!-- plugin js -->
    <script src="assets/libs/moment/min/moment.min.js"></script>
    <script src="assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
    <script src="assets/libs/@fullcalendar/core/main.min.js"></script>
    <script src="assets/libs/@fullcalendar/bootstrap/main.min.js"></script>
    <script src="assets/libs/@fullcalendar/daygrid/main.min.js"></script>
    <script src="assets/libs/@fullcalendar/timegrid/main.min.js"></script>
    <script src="assets/libs/@fullcalendar/interaction/main.min.js"></script>

    <script src="assets/js/main.js"></script>

    <!-- Calendar init -->
    <script src="assets/js/pages/calendar.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>