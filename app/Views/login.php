<?= $this->include('partials/main') ?>

<head>

    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50 mb-0">Sign in to continue to BrightStar Logistics.</p>
                                <a href="/" class="logo logo-admin mt-4">
                                    <img src="assets/images/logo.png" class="rounded-circle" alt="logo-sm-dark" width="100%">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form class="form-horizontal" action="<?= base_url('Home/postLogin') ?>">
                                    
                                    <?= $this->include('partials/alert') ?>
                                        
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password">
                                    </div>
                                    
                                    <!--
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Remember
                                            me</label>
                                    </div>
                                    -->

                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                    
                                    <!--
                                    <div class="mt-4 text-center">
                                        <a href="pages-recoverpw" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                    -->
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <!--
                        <p>Don't have an account ? <a href="pages-register" class="fw-medium text-primary"> Signup now </a> </p>
                        -->
                        <p>&copy; <script>
                                document.write(new Date().getFullYear())
                            </script> BrightStar Logistics. All Rights Reserved.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <?= $this->include('partials/vendor-scripts') ?>

    <script src="assets/js/app.js"></script>

</body>

</html>