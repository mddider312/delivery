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

                    <div class="checkout-tabs">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-gen-ques-tab" data-bs-toggle="pill"
                                        href="#v-pills-gen-ques" role="tab" aria-controls="v-pills-gen-ques"
                                        aria-selected="true">
                                        <i class="bx bx-question-mark d-block check-nav-icon mt-4 mb-2"></i>
                                        <p class="fw-bold mb-4">General Questions</p>
                                    </a>
                                    <a class="nav-link" id="v-pills-privacy-tab" data-bs-toggle="pill"
                                        href="#v-pills-privacy" role="tab" aria-controls="v-pills-privacy"
                                        aria-selected="false">
                                        <i class="bx bx-check-shield d-block check-nav-icon mt-4 mb-2"></i>
                                        <p class="fw-bold mb-4">Privacy Policy</p>
                                    </a>
                                    <a class="nav-link" id="v-pills-support-tab" data-bs-toggle="pill"
                                        href="#v-pills-support" role="tab" aria-controls="v-pills-support"
                                        aria-selected="false">
                                        <i class="bx bx-support d-block check-nav-icon mt-4 mb-2"></i>
                                        <p class="fw-bold mb-4">Support</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-gen-ques" role="tabpanel"
                                                aria-labelledby="v-pills-gen-ques-tab">
                                                <h4 class="card-title mb-5">General Questions</h4>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">What is Lorem Ipsum?</h5>
                                                        <p class="text-muted">New common language will be more simple
                                                            and regular than the existing European languages. It will be
                                                            as simple as occidental.</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where does it come from?</h5>
                                                        <p class="text-muted">Everyone realizes why a new common
                                                            language would be desirable one could refuse to pay
                                                            expensive translators.</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where can I get some?</h5>
                                                        <p class="text-muted">If several languages coalesce, the grammar
                                                            of the resulting language is more simple and regular than
                                                            that of the individual languages.</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Why do we use it?</h5>
                                                        <p class="text-muted">Their separate existence is a myth. For
                                                            science, music, sport, etc, Europe uses the same vocabulary.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where can I get some?</h5>
                                                        <p class="text-muted">To an English person, it will seem like
                                                            simplified English, as a skeptical Cambridge friend of mine
                                                            told me what Occidental</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel"
                                                aria-labelledby="v-pills-privacy-tab">
                                                <h4 class="card-title mb-5">Privacy Policy</h4>

                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where does it come from?</h5>
                                                        <p class="text-muted">Everyone realizes why a new common
                                                            language would be desirable one could refuse to pay
                                                            expensive translators.</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where can I get some?</h5>
                                                        <p class="text-muted">To an English person, it will seem like
                                                            simplified English, as a skeptical Cambridge friend of mine
                                                            told me what Occidental</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">What is Lorem Ipsum?</h5>
                                                        <p class="text-muted">New common language will be more simple
                                                            and regular than the existing European languages. It will be
                                                            as simple as occidental.</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Why do we use it?</h5>
                                                        <p class="text-muted">Their separate existence is a myth. For
                                                            science, music, sport, etc, Europe uses the same vocabulary.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where can I get some?</h5>
                                                        <p class="text-muted">If several languages coalesce, the grammar
                                                            of the resulting language is more simple and regular than
                                                            that of the individual languages.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-support" role="tabpanel"
                                                aria-labelledby="v-pills-support-tab">
                                                <h4 class="card-title mb-5">Support</h4>

                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where can I get some?</h5>
                                                        <p class="text-muted">To an English person, it will seem like
                                                            simplified English, as a skeptical Cambridge friend of mine
                                                            told me what Occidental</p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where does it come from?</h5>
                                                        <p class="text-muted">Everyone realizes why a new common
                                                            language would be desirable one could refuse to pay
                                                            expensive translators.</p>
                                                    </div>
                                                </div>

                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Why do we use it?</h5>
                                                        <p class="text-muted">Their separate existence is a myth. For
                                                            science, music, sport, etc, Europe uses the same vocabulary.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="faq-box d-flex align-items-start mb-4">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">Where can I get some?</h5>
                                                        <p class="text-muted">If several languages coalesce, the grammar
                                                            of the resulting language is more simple and regular than
                                                            that of the individual languages.</p>
                                                    </div>
                                                </div>

                                                <div class="faq-box d-flex">
                                                    <div class="faq-icon me-3">
                                                        <i class="bx bx-help-circle font-size-20 text-success"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-15">What is Lorem Ipsum?</h5>
                                                        <p class="text-muted">New common language will be more simple
                                                            and regular than the existing European languages. It will be
                                                            as simple as occidental.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>