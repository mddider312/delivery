<?= $this->include('partials/main') ?>

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/head-css') ?>
</head>

<style>
    .btn:hover {
        background-color: grey;
        color: white;
    }
    
    .btn {
        background-color: #EE0263;
        border: 1px solid #EE0263;
    }
    
    body[data-layout="detached"] #layout-wrapper::before {
    	background: #EE0263 !important;
    }
    
    footer {
        background: transparent !important;
    }
</style>

<?= $this->include('partials/body') ?>
    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php $this->include('partials/menu'); ?>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex justify-content-between">
                            
                            <div class="d-flex flex-row-reverse m-0 w-100">
                                <div class="row w-100" style="padding-right:20px;">
                                    
                                    <div class="col-md-10">
                                        <img class="img-responsive mt-2" src="<?= base_url('assets/images/logo.png') ?>" style="height: 50px;">
                                        <!--<h4 class="page-title mb-0"><?= $title ?></h4>-->
                                    </div>
                                    
                                    <div class="dropdown col-md-2 mb-3" style="text-align: right; padding-top:10px;">
                                        
                                        <!-- Workshop ID -->
                                        <button class="dropdown-toggle <?= $agent_id != 0 ? 'btn btn-secondary disabled' : 'btn btn-primary' ?>" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #012435; border: 1px solid #012435;">
                                            <i class="mdi mdi-account" style="font-size: 20px;"></i>
                                            <?php
                                                if ($workshop_id != 0) {
                                            ?>
                                                    <i class="mdi mdi-checkbox-blank-circle text-white" style="font-size: 10px;"></i>
                                            <?php
                                                }
                                            ?>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" style="min-width:350px; position:absolute; inset:0px auto auto 0px; margin:0px; transform:translate(-33px, 72px);" data-popper-placement="bottom-end">
                                            <h4 class="mb-0 font-size-18 m-3 mt-2">Enter Workshop ID (optional)</h4>
                                            
                                            <div class="input-group p-2">
                                                <input class="form-control" type="text" name="workshop_id" id="workshop_id" value="<?= $workshop_id == 0 ? '' : $workshop_id ?>" placeholder="Workshop ID (optional)" onkeypress="return isNumber(event);">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary input-group-text" onclick="validateWorkshop();"><i class="mdi mdi-arrow-right" style="font-size: 20px;"></i></button>
                                                </div>
                                            </div>
                                            
                                            <?php
                                                if ($workshop_id != 0) {
                                            ?>
                                                    <span class="p-2" style="color: #092737;">Success! Workshop ID assigned.&nbsp;<a href="#" class="link-danger" style="color: #EE0263;" onclick="revokeWorkshop();"><u>Revoke</u></a></span>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                        <!-- Workshop ID -->
                                        
                                        <!-- Search -->
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="filter-search-btn" style="background-color: #012435; border: 1px solid #012435;">
                                            <i class="mdi mdi-magnify" style="font-size: 20px;"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" style="min-width:350px; position:absolute; inset:0px auto auto 0px; margin:0px; transform:translate(-33px, 72px);" data-popper-placement="bottom-end">
                                            <h4 class="mb-0 font-size-18 m-3 mt-2">Search Product</h4>
                                            
                                            <div class="input-group p-2">
                                                <input class="form-control" type="text" name="product_name" id="product_name" placeholder="Search Product">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary input-group-text" onclick="filter('search', '');"><i class="mdi mdi-magnify" style="font-size: 20px;"></i></button>
                                                </div>
                                            </div>
                                        </ul>
                                        <!-- Search -->
                                        
                                        <!-- Cart -->
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #012435; border: 1px solid #012435;">
                                            <i class="mdi mdi-cart" style="font-size: 20px;"></i><span class="badge badge-light" style="font-size: 16px;" id="cart-count">0</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" style="min-width:350px; position:absolute; inset:0px auto auto 0px; margin:0px; transform:translate(-33px, 72px);" data-popper-placement="bottom-end">
                                            <h4 class="mb-0 font-size-18 m-3 mt-2">Your Cart</h4>
                                            <hr>
                                            
                                            <div id="cart-list">
                                                
                                            </div>

                                            <li class="m-2" style="text-align: right;" id="cart-total-li">
                                                <span>Subtotal (RM): <span id="cart-total">0.00</span></span>
                                            </li>
                                            
                                            <li class="m-2">
                                                <a class="btn btn-info w-100" id="checkout-btn" type="button" onclick="checkout();" *href="<?php echo base_url('customer/cart')?>">
                                                    Checkout
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Cart -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <h5 class="page-title mb-2">SHOWING PRODUCTS : <span id="showing-product-count"></span></h5>
                    
                    <!-- Filter Button-->
                      <div class="btn-group mb-2">
                        <div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" id="filter-brand-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            Brand
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="filter-brand-btn">
                            <li><a class="dropdown-item" href="#" onclick="filter('brand', '0');">No Brand</a></li>
                            <?php
                                foreach ($brands as $b) {
                            ?>
                                    <li><a class="dropdown-item" href="#" onclick="filter('brand', '<?= $b['product_brand_id'] ?>');"><?= $b['brand_name'] ?></a></li>
                            <?php
                                }
                            ?>
                          </ul>
                        </div>
                        
                        &nbsp;
                        
                        <div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" id="filter-category-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            Category
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="filter-category-btn">
                            <li><a class="dropdown-item" href="#" onclick="filter('category', '0');">No Category</a></li>
                            <?php
                                foreach ($categories as $c) {
                            ?>
                                    <li><a class="dropdown-item" href="#" onclick="filter('category', '<?= $c['product_category_id'] ?>');"><?= $c['category_name'] ?></a></li>
                            <?php
                                }
                            ?>
                          </ul>
                        </div> 
                        
                        &nbsp;
                        
                        <div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" id="filter-size-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            Size
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="filter-size-btn">
                            <li><a class="dropdown-item" href="#" onclick="filter('size', '0');">No Size</a></li>
                            <?php
                                foreach ($sizes as $s) {
                            ?>
                                    <li><a class="dropdown-item" href="#" onclick="filter('size', '<?= $s['product_size_id'] ?>');"><?= $s['size_name'] ?></a></li>
                            <?php
                                }
                            ?>
                          </ul>
                        </div>
                        
                        &emsp;
                      
                        <a href="#" class="link-primary d-flex align-items-center d-none" onclick="filter('reset', '');" id="filter-reset-btn">
                            <u>Reset</u>
                        </a>
                      </div>
                      
                      
                    <!-- Filter Button-->
                    
                    <!-- Modal -->
                    <div class="modal fade" id="productDetailModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modal-product-name"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" style="overflow-y: auto;">
                            <div class="row mb-2">
                                <div class="thumbnail">
                                    <img id="modal-product-photo" src="" alt="" class="img img-fluid rounded" style="width:100%;">
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Price (RM) :</label>
                                <h6 id="modal-product-price" style="padding-left:30px;"></h6>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Warranty :</label>
                                <h6 id="modal-product-warranty" style="padding-left:30px;"></h6>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Quantity :</label>
                                <div class="input-group mb-2 w-50 input-group-sm" id="modal-product-quantity" style="padding-left:30px;">
                                  
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Description :</label>
                                <h6 id="modal-product-description" style="white-space:pre-wrap; padding-left:30px;"></h6>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Brand :</label>
                                <h6 id="modal-product-brand" style="padding-left:30px;"></h6>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Category :</label>
                                <h6 id="modal-product-category" style="padding-left:30px;"></h6>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="form-label">Size :</label>
                                <h6 id="modal-product-size" style="padding-left:30px;"></h6>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <div id="modal-add-to-cart">
                                
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" id="product-list">
                        
                    </div>
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
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var products = [];
        var trade_in_types = <?= json_encode($trade_in_types) ?>;
        var brands = <?= json_encode($brands) ?>;
        var categories = <?= json_encode($categories) ?>;
        var sizes = <?= json_encode($sizes) ?>;
        var payment_status = "<?= $payment_status ?>";
        var global_workshop_id = "<?= $workshop_id ?? 0 ?>";
        var global_partner_id = "<?= $partner_id ?>";
        
        let filter_search = "";
        let filter_brand_id = "";
        let filter_category_id = "";
        let filter_size_id = "";
        
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        const formatter = new Intl.NumberFormat('en-US', {
           minimumFractionDigits: 2,      
           maximumFractionDigits: 2,
        });

        $(document).ready(function () {
            switch (payment_status) {
                case "0": // not paid
                    post_checkout_swal("error", "Failed to place the order. Please try again later.");
                    break;
                case "1": // paid
                    window.sessionStorage.removeItem('cart');
                    swal_order_details("2", "<?= $order_id ?>", "<?= $trade_in_id ?>", "Successfully placed an order. Thank you!");
                    break;
                case "2": // paid and have trade-ins
                    window.sessionStorage.removeItem('cart');
                    swal_order_details("3", "<?= $order_id ?>", "<?= $trade_in_id ?>", "Successfully placed an order. A driver will come pickup the batteries. Thank you!");
                    break;
            }
            
            checkAgent();
        });
        
        function checkAgent() {
            var agent_id = "<?= $agent_id ?>";
            
            if (agent_id != "0") {
                var select_partner_message = '<p class="font-size-18 text-left">Please select a partner to proceed: (Required <span class="text-danger">*</span>)</p>';
                var order_message = '';
                
                switch (payment_status) {
                    case "0": // not paid
                        order_message = '<p class="font-size-18 text-left" style="color: red;">Failed to place the order. Please try again later.</p><br><hr><br>';
                        break;
                    case "1": // paid
                        window.sessionStorage.removeItem('cart');
                        order_message = '<p class="font-size-18 text-left">Successfully placed an order. Thank you for purchase with Bateri Laju!</p><br><hr><br>';
                        break;
                    case "2": // paid and have trade-ins
                        window.sessionStorage.removeItem('cart');
                        order_message = '<p class="font-size-18 text-left">Successfully placed an order. A driver will come pickup the batteries. Thank you for purchase with Bateri Laju!</p><br><hr><br>';
                        break;
                }
                
                Swal.fire({
                  title: 
                    payment_status
                        ? order_message + select_partner_message
                        : select_partner_message,
                  html: 
                  ` 
                    <input name="agent_id" id="agent-id-hidden" value="<?= $agent_id ?>" hidden>

                    <div class="col-md-12 mb-2" style="text-align: left;">
                        <label class="form-label font-size-14">Partner <span class="text-danger">*</span></label>
                        <select class="form-control" name="partner_id" id="agent-select-partner" value="0" required>
                            <option value="0" hidden>-- Please Select --</option>
                            <?php
                                foreach ($partners as $partner) {
                            ?>
                                    <option value="<?= $partner['id'] ?>"><?= $partner['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                  `,
                  icon: payment_status == "" ? '' : (payment_status == "0" ? 'error' : 'success'),
                  backdrop: true,
                  showCancelButton: false,
                  allowOutsideClick: false,
                  confirmButtonText: 'Proceed',
                  preConfirm: function () {
                    if ($('#agent-select-partner').val() == "0") {
                        Swal.showValidationMessage('Please select a partner to proceed.');
                    }

                    return new Promise(function (resolve) {
                      resolve([
                        $('#agent-id-hidden').val(),
                        $('#agent-select-partner').val(),
                      ])
                    })
                  },
                  onOpen: function () {
                    $('#agent-select-partner').focus()
                  }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        var agent_id = result['value'][0];
                        var partner_id = result['value'][1];
                        
                        global_partner_id = partner_id;
                        
                        loadProduct();
                    }
                }).catch(swal.noop);
            } else {
                loadProduct();
            }
        }
        
        function filter(type, data) {
            switch (type) {
                case "search":
                    var search = $('#product_name').val();
                    if (search) {
                        $('#filter-reset-btn').removeClass('d-none');
                        $("#filter-search-btn").css("background-color","#092737").css("border","1px solid #EE0263");
                        filter_search = search;
                    }
                    break;
                case "brand":
                    $('#filter-reset-btn').removeClass('d-none');
                    $("#filter-brand-btn").css("background-color","#092737").css("border","1px solid #092737");
                    filter_brand_id = data;
                    break;
                case "category":
                    $('#filter-reset-btn').removeClass('d-none');
                    $("#filter-category-btn").css("background-color","#092737").css("border","1px solid #092737");
                    filter_category_id = data;
                    break;
                case "size":
                    $('#filter-reset-btn').removeClass('d-none');
                    $("#filter-size-btn").css("background-color","#092737").css("border","1px solid #092737");
                    filter_size_id = data;
                    break;
                case "reset":
                    $('#filter-reset-btn').addClass('d-none');
                    $("#filter-search-btn").css("background-color","#EE0263").css("border","1px solid #EE0263");
                    $("#filter-brand-btn").css("background-color","#EE0263").css("border","1px solid #EE0263");
                    $("#filter-category-btn").css("background-color","#EE0263").css("border","1px solid #EE0263");
                    $("#filter-size-btn").css("background-color","#EE0263").css("border","1px solid #EE0263");
                    $('#product_name').val('');
                    filter_search = "";
                    filter_brand_id = "";
                    filter_category_id = "";
                    filter_size_id = "";
                    break;
            }
            
            loadProduct();
        }
        
        function loadProduct() {
            $.post("<?= base_url("CustomerController/load_product") ?>", {
                partner_id: global_partner_id,
                search: filter_search,
                brand_id: filter_brand_id,
                category_id: filter_category_id,
                size_id: filter_size_id,
            }, function(data, status){
                var p = JSON.parse(data);
                products = p;
                var product_html = "";
                $('#showing-product-count').text(p.length);
   
                for (var i = 0; i < p.length; i++) {
                    product_html += `
                        <div class="col-6 col-lg-2 col-md-4 d-flex justify-content-center p-1">
                            <div class="card mb-0">
                                <form action="<?= base_url('customer/add_cart');?>" method="POST">
                                    <div class="card-body text-center p-2" style="display:flex; flex-direction:column; height:100%;">
                                        <div class="row mb-2" data-bs-toggle="modal" data-bs-target="#productDetailModel" onclick="displayProductDetail(` + p[i]['id'] + `, ` + global_workshop_id + `)" style="overflow:hidden;">
                                            <div class="thumbnail">
                                                <img src="<?= base_url() ?>/` + p[i]['photo'] + `" alt="" class="img img-fluid rounded" style="overflow:hidden; width:100%; height:auto;">
                                            </div>
                                        </div>
                                        
                                        <div class="row" style="flex-grow:1;">
                                            <div class="col-12">
                                                <h6 data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="` + p[i]['name'] + `" style="overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:1; line-clamp:1; -webkit-box-orient:vertical; color:black;">` + p[i]['name'] + `</h6>
                                            </div>
                                            
                                            <div class="col-12">
                                                <h6 style="color: #EE0263;">RM ` + 
                                                    (global_workshop_id == "0" 
                                                        ? p[i]['selling_price'] 
                                                        : ("<s>"+p[i]['selling_price']+"</s>&nbsp;"+p[i]['workshop_price'])) 
                                                + `</h6>
                                            </div>
                                            
                                            <div class="col-12">
                                                <input type="hidden" name="product_id" value="` + p[i]['id'] + `">
                                                <button class="btn btn-primary btn-block w-100" type="button" data-bs-toggle="modal" data-bs-target="#productDetailModel" onclick="displayProductDetail(` + p[i]['id'] + `, ` + global_workshop_id + `);"> Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    `;
                }
                
                $('#product-list').html(product_html);
                
                loadCart();
            });
        }
        
        function swal(type, position, message, backdrop, timer, showConfirmButton) {
            if (timer > 0) {
                Swal.fire({
                  position: position,
                  icon: type,
                  title: message,
                  backdrop: backdrop,
                  showConfirmButton: showConfirmButton,
                  timer: timer,
                });
            } else {
                Swal.fire({
                  position: position,
                  icon: type,
                  title: message,
                  backdrop: backdrop,
                  showConfirmButton: showConfirmButton,
                });
            }
        }
        
        function post_checkout_swal(type, message) {
            Swal.fire({
              position: 'center',
              icon: type,
              title: message,
              showConfirmButton: true,
              confirmButtonText: 'OK',
              backdrop: true,
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = "<?= site_url('shop') ?>" + "/" + global_partner_id + "/" + global_workshop_id;
                }
            }).catch(swal.noop);
        }
        
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        
        function extractInputArray(inputArray) {
            var arr = [];
            
            for (var i = 0; i < inputArray.length; i++) {
                arr.push(inputArray[i].value);
            }
            
            return arr;
        }
        
        function displayProductDetail(product_id, workshop_id) {
            for (var i=0; i<products.length; i++) {
                if (products[i]['id'] == product_id) {
                    $("#modal-product-photo").attr("src", "<?= base_url() ?>/" + products[i]['photo']);
                    $('#modal-product-name').text(products[i]['name']);
                    
                    if (workshop_id == 0) {
                        $('#modal-product-price').text(products[i]['selling_price']);
                        $('#modal-product-warranty').text(products[i]['warranty_month'] + " Month(s)");
                    } else {
                        $('#modal-product-price').html("<s>" + products[i]['selling_price'] + "</s>&ensp;" + products[i]['workshop_price']);
                        $('#modal-product-warranty').text(products[i]['workshop_warranty_month'] + " Month(s)");
                    }
                    
                    $('#modal-product-quantity').html(`
                        <button type="button" class="input-group-text btn btn-primary btn-sm" onclick="modifyQuantity('add', '`+ product_id + `');">
                            <i class="mdi mdi-plus" style="font-size: 15px;"></i>
                        </button>
                        <input class="form-control" type="text" id="product-quantity-`+ product_id + `" value="1" onkeypress="return isNumber(event);" onkeyup="modifyQuantity('input', '`+ product_id + `');" onchange="modifyQuantity('input', '`+ product_id + `');" style="text-align:center;">
                        <button type="button" class="input-group-text btn btn-primary btn-sm" onclick="modifyQuantity('minus', '`+ product_id + `');">
                            <i class="mdi mdi-minus" style="font-size: 15px;"></i>
                        </button>
                    `);
                    
                    if (products[i]['description'].length == 0)
                        $('#modal-product-description').text("n/a");
                    else
                        $('#modal-product-description').text(products[i]['description']);
                    
                    $('#modal-product-brand').text("n/a");
                    for (var j = 0; j < brands.length; j++)
                        if (brands[j]['product_brand_id'] == products[i]['brand_id'])
                            $('#modal-product-brand').text(brands[j]['brand_name']);
                    
                    $('#modal-product-category').text("n/a");
                    for (var j = 0; j < categories.length; j++)
                        if (categories[j]['product_category_id'] == products[i]['category_id'])
                            $('#modal-product-category').text(categories[j]['category_name']);
                    
                    $('#modal-product-size').text("n/a");
                    for (var j = 0; j < sizes.length; j++)
                        if (sizes[j]['product_size_id'] == products[i]['size_id'])
                            $('#modal-product-size').text(sizes[j]['size_name']);
                    
                    $('#modal-add-to-cart').html(`
                        <button class="btn btn-primary btn-block w-100" type="button" data-bs-dismiss="modal" onclick="addToCart('`+ product_id + `');"> Add to Cart</button>
                    `);
                    
                    break;
                }
            }
        }

        function modifyQuantity(type, product_id) {
            var x = $('#product-quantity-' + product_id).val();
            
            if (isNaN(x) || x == "") {
                $('#product-quantity-' + product_id).val(1);
            } else {
                var x = parseInt(x);
                
                if (type == "add") {
                    $('#product-quantity-' + product_id).val(x+1);
                } else if (type == "minus") {
                    if (x != 1) {
                        $('#product-quantity-' + product_id).val(x-1);
                    }
                } else if (type == "input") {
                    if (x == 0) {
                        $('#product-quantity-' + product_id).val(1);
                    }
                }
            }
                
        }
        
        function addToCart(product_id) {
            var qty = $('#product-quantity-' + product_id).val();
            $('#product-quantity-' + product_id).val(1);
            
            if (isNaN(qty) || qty == "") {
                qty = 1;
            }
            
            var cart = JSON.parse(sessionStorage.getItem("cart")) ?? [];
            
            
            for (var i=0; i<products.length; i++) {
                var found = false;
                
                if (products[i]['id'] == product_id) {
                    for (var j=0; j<cart.length; j++) {
                        if (cart[j][0] == product_id) {
                            var sum = parseInt(cart[j][1]) + parseInt(qty);
                            cart.splice(j, 1);
                            
                            var cart_product = [product_id, sum.toString()];
                            cart = [cart_product].concat(cart);
                        
                            found = true;
                            
                            break;
                        }
                    }
                    
                    if (found == false) {
                        var cart_product = [product_id, qty.toString()];
                        cart = [cart_product].concat(cart);

                        window.sessionStorage.setItem("cart", JSON.stringify(cart));
                    }
                    
                    break;
                }
            }
            
            window.sessionStorage.setItem("cart", JSON.stringify(cart));
            swal('success', 'center', 'Successfully added product to cart.', false, 1500, false);
            
            var session_cart = JSON.parse(sessionStorage.getItem("cart"));
            console.log(session_cart);
            
            loadCart();
        }
        
        function loadCart() {
            var workshop_id = "<?= $workshop_id ?>";
            $("#cart-list").html("");
            var cart = JSON.parse(sessionStorage.getItem("cart"));
            var grandtotal = parseFloat(0.00);
            
            if (cart == null || cart.length == 0) {
                window.sessionStorage.removeItem('cart');
                $("#cart-list").html("<p class='text-center'>Cart is empty.</p>");
                $("#cart-count").text("0");
                $("#cart-total").text(grandtotal.toFixed(2));
    
                window.sessionStorage.setItem("grand_total", grandtotal.toFixed(2));
                document.getElementById("cart-total-li").className = "m-2 d-none";
                //document.getElementById("checkout-btn").className = "btn btn-info w-100 disabled";
            } else {
                $("#cart-count").text(cart.length);
                document.getElementById("cart-total-li").className = "m-2";
                document.getElementById("checkout-btn").className = "btn btn-info w-100";
            }
            
            if (cart != null) {
                if (products.length == 0) {
                    swal("info", "center", "Cart updated.", false, 1000, false);
                    window.sessionStorage.removeItem('cart');
                    $("#cart-count").text("0");
                } else {
                    var remove = [];
                    var has_remove = false;
                    
                    for (var i=0; i<cart.length; i++) {
                        for (var j=0; j<products.length; j++) {
                            if (products[j]['id'] == cart[i][0]) {
                                var product_id = products[j]['id'];
                                var photo = "<?= base_url() ?>/" + products[j]['photo'];
                                var name = products[j]['name'];
                                var price = workshop_id == "0" ? products[j]['selling_price'] : products[j]['workshop_price'];
                                var quantity = cart[i][1];
                                var subtotal = parseFloat(price) * parseInt(quantity);
                                grandtotal = grandtotal + parseFloat(subtotal);
                                
                                var cart_item = `
                                    <li class="m-2" style="padding-bottom: 10px; border-bottom: 1px solid #D3D3D3;">
                                        <div class="row">
                                            <div class="col-md-4 col-4">
                                                <img src="`+ photo +`" style="width:100%;" alt="">
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="row">`+ name +`</div>
                                                <div class="row">Quantity: `+ quantity +`</div>
                                                <div class="row">Price: RM `+ price +`</div>
                                            </div>
                                            <div class="col-md-2 col-2">
                                                <a href="#" onclick="removeCartItem(this, `+ i +`); return false;" class="remove">
                                                    <i class="mdi mdi-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                `;
                                  
                                $("#cart-list").append(cart_item);
                                $("#cart-total").text(grandtotal.toFixed(2));
                                
                                window.sessionStorage.setItem("grand_total", grandtotal.toFixed(2));
                                
                                break;
                            }
                            
                            if (j == products.length-1) {
                                remove.push(i);
                                has_remove = true;
                            }
                        }
                    }
                    
                    if (has_remove) {
                        for (var i = 0; i < remove.length; i++) {
                            cart.splice(remove[i], 1);
                        }
                        
                        swal("info", "center", "Cart updated.", false, 1000, false);
                    }
                        
                    
                    $("#cart-count").text(cart.length);
                    window.sessionStorage.setItem("cart", JSON.stringify(cart));
                }
            }
        }
        
        function removeCartItem(ele, index) {
            Swal.fire({
              title: 'Remove this product from the cart ?',
              showCancelButton: true,
              confirmButtonText: 'Confirm',
            }).then((result) => {
              if (result.isConfirmed) {
                var cart = JSON.parse(sessionStorage.getItem("cart"));
                cart.splice(index, 1);
                window.sessionStorage.setItem("cart", JSON.stringify(cart));
                
                ele.parentNode.parentNode.parentNode.remove();
                swal("success", "center", "Successfully removed product from the cart.", false, 1500, false);
                loadCart();
              }
            });
        }
        
        function validateWorkshop() {
            var workshop_id = $('#workshop_id').val();
            
            if (workshop_id != "") {
                location.href = "<?= site_url('shop') ?>" + "/" + global_partner_id + "/" + workshop_id;
            }
        }
        
        function revokeWorkshop() {
            location.href = "<?= site_url('shop') ?>" + "/" + global_partner_id;
        }
        
        function validateVoucher() {
            var voucher_code = $('#voucher-code').val();
            
            if (voucher_code) {
                $.post("<?= base_url('CustomerController/validate_voucher') ?>", {
                    voucher_code: voucher_code,
                }, function(data, status){
                    var response = JSON.parse(data);
                    var message = "";
                    
                    if (response['status'] == "success") {
                        var grand_total = $("#cart-total").text();
                        var new_grand_total = 0;
                        
                        $('#voucher-code-hidden').val(voucher_code);
                        
                        switch(response['type']) {
                            case "0": // Percentage formatter.format(2.005)
                                var percentage = 100 - response['discount_amount'];
                                new_grand_total = formatter.format(grand_total / 100 * percentage);
                                var discount = formatter.format(grand_total - new_grand_total);
                                
                                $('#voucher-discount-hidden').val(discount);
                                
                                message = voucher_code + " (" + response['discount_amount'] + "%) -RM " + discount;
                                break;
                            case "1": // Amount
                                new_grand_total = grand_total - response['discount_amount'];
                                
                                $('#voucher-discount-hidden').val(response['discount_amount']);
                            
                                message = voucher_code + " (-RM " + response['discount_amount'] + ")";
                                break;
                        }
                        $('#final-total').val(new_grand_total);
                        validateTradeIn();
                    } else {
                        message = "(Invalid voucher code.)";
                        validateTradeIn();
                    }
                    
                    $('#voucher-code-label').text(message);
                });
            }
        }
        
        function validateTradeIn() {
            var cart = JSON.parse(sessionStorage.getItem("cart"));
            var cart_total = $('#cart-total').text();
            var discount_total = $('#voucher-discount-hidden').val();
            var trade_in_total = parseFloat(0.00);

            for (var j=0; j<trade_in_types.length; j++) {
                var k = trade_in_types[j]['trade_in_type_id'];
                var trade_in_type_id = $('#trade-in-type-id-' + k).val();
                var trade_in_quantity = $('#trade-in-quantity-' + k).val();
                var trade_in_discount = $('#trade-in-discount-' + k).val();
                
                
                if (isNaN(trade_in_quantity)) {
                    trade_in_quantity = 0;
                    $('#trade-in-quantity-' + k).val(0);
                    $('#trade-in-discount-' + k).val(0.00);
                } else {
                    var cart_length = cart == null ? 0 : cart.length;
                    var trade_in_subtotal = trade_in_types[j]['value_without_order'] * trade_in_quantity;
                    
                    if (trade_in_subtotal != 0.00) {
                        var adjustment = (trade_in_types[j]['value_with_order'] - trade_in_types[j]['value_without_order']) * cart_length;
                        trade_in_subtotal = trade_in_subtotal + adjustment;
                    }
                    
                    $('#trade-in-discount-' + k).val(trade_in_subtotal.toFixed(2));
                    
                    trade_in_total = trade_in_total + parseFloat(trade_in_subtotal);
                }
            }
            
            $("#trade-in-discount").val(trade_in_total.toFixed(2));
            
            var new_final_total = parseFloat(cart_total) - parseFloat(trade_in_total) - parseFloat(discount_total);
            $("#final-total").val(new_final_total.toFixed(2));
        }
        
        function checkout() {
            var grand_total = $("#cart-total").text();
            var workshop_id = "<?= $workshop_id ?>";
            var agent_id = "<?= $agent_id ?>";
            var cart = JSON.parse(sessionStorage.getItem("cart"));

            Swal.fire({
              title: '<p class="font-size-18">Please fill up the following to place order/trade-in: (Required <span class="text-danger">*</span>)</p>',
              html: 
              ` 
                <input name="condition" id="condition-hidden" value="0" hidden><!-- 0-invalid, 1-tradein only, 2-order only, 3-tradein and order -->
                <input name="workshop_id" id="workshop-id-hidden" value="`+ workshop_id +`" hidden>
                <input name="agent_id" id="agent-id-hidden" value="`+ agent_id +`" hidden>
                <input name="voucher_code" id="voucher-code-hidden" value="" hidden>
                <input name="voucher_discount" id="voucher-discount-hidden" value="0.00" hidden>
                <input name="grand_total" id="grand-total-hidden" value="0.00" hidden>
                
                <div id="notice-area">
                
                </div>

                <div class="col-md-12 mb-2" style="text-align: left;">
                    <label class="form-label font-size-14">Your Name <span class="text-danger">*</span></label>
                    <input class="form-control form-control-sm" type="text" name="customer_name" id="customer_name" value="Lim Mei Mei">
                </div>
                <div class="col-md-12 mb-2" style="text-align: left;">
                    <label class="form-label font-size-14">Phone Number <span class="text-danger">*</span></label>
                    <input class="form-control form-control-sm" type="text" name="customer_phone" id="customer_phone" value="0123456789">
                </div>
                <div class="col-md-12 mb-2" style="text-align: left;">
                    <label class="form-label font-size-14">Your Car License Plate <span class="text-danger">*</span></label>
                    <input class="form-control form-control-sm" type="text" name="license_plate" id="license_plate" value="ABB1234">
                </div>
                <div class="col-md-12 mb-2" style="text-align: left;">
                    <label class="form-label font-size-14">Address</label>
                    <textarea class="form-control form-control-sm" name="customer_address" id="customer_address" rows="3">1, Jln Bunga 3 Taman Oren 5</textarea>
                </div>
                <div class="col-md-12 mb-2" style="text-align: left;">
                    <label class="form-label font-size-14">Voucher Code <span id="voucher-code-label" style="color:red; font-size:12px;"></span></label>
                    <div class="input-group mb-2">
                        <input class="form-control form-control-sm" type="text" id="voucher-code" value="ABC123">
                        <div class="input-group-append">
                            <button class="btn btn-primary input-group-text btn-sm" onclick="validateVoucher();"><b id="voucher-btn">APPLY</b></button>
                        </div>
                    </div>
                </div>
                
                <div id="trade-in-list" class="col-md-12 table-responsive">
                    <h4 class="font-size-14 mt-2" style="text-align:left;">Battery Trade-In</h4>
                    <table class="table table-bordered table-striped table-sm font-size-14">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:40%;">Type</th>
                                <th class="text-center" style="width:20%;">Qty</th>
                                <th class="text-center" style="width:40%;">Discount (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($trade_in_types as $trade_in_type) {
                            ?>
                                    <tr>
                                        <td style="text-align:left;">
                                            <input name="trade_in_type_id[]" class="trade_in_type_id" id="trade-in-type-id-<?= $trade_in_type['trade_in_type_id'] ?>" value="<?= $trade_in_type['trade_in_type_id'] ?>" hidden>
                                            <?= $trade_in_type['type'] ?>
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm trade_in_quantity" type="text" name="trade_in_quantity[]" id="trade-in-quantity-<?= $trade_in_type['trade_in_type_id'] ?>" onkeypress="return isNumber(event);" value="0">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm trade_in_discount" type="text" name="trade_in_discount[]" id="trade-in-discount-<?= $trade_in_type['trade_in_type_id'] ?>" value="0.00" disabled>
                                        </td>
                                    </tr>
                                    
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <button class="btn btn-primary btn-sm w-100" onclick="validateTradeIn();"><b id="trade-in-btn">APPLY</b></button>
                                </td>
                                <td>Total:</td>
                                <td>
                                    <input class="form-control form-control-sm" type="text" name="trade_in_discount_total" value="0.00" disabled id="trade-in-discount">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <hr>
                 
                <div class="col-md-12 mb-2" style="text-align: left;">
                    <label class="form-label font-size-14" id="final-total-label">Amount To Pay (RM)</label>
                    <input class="form-control form-control-sm" type="text" name="final_total" value="`+ grand_total +`" disabled id="final-total">
                </div>
              `,
              showCancelButton: true,
              allowOutsideClick: false,
              confirmButtonText: 'Place Order',
              confirmButtonColor: '#EE0263',
              cancelButtonColor: '#012435',
              preConfirm: function () {
                if (!$('#customer_name').val() || !$('#customer_phone').val() || !$('#license_plate').val()) {
                    Swal.showValidationMessage('Please fill up all required fields.');
                }
                
                if ($('#trade-in-discount').val() == 0 && cart == null) { // invalid
                    $('#condition-hidden').val(0);
                }
                
                if ($('#trade-in-discount').val() != 0 && cart == null) { // tradein only
                    $('#condition-hidden').val(1);
                }
                
                if ($('#trade-in-discount').val() == 0 && cart != null) { // order only
                    $('#condition-hidden').val(2);
                }
                
                if ($('#trade-in-discount').val() != 0 && cart != null) { // tradein and order
                    $('#condition-hidden').val(3);
                }
                  
                return new Promise(function (resolve) {
                  resolve([
                    $('#condition-hidden').val(),
                    $('#customer_name').val(),
                    $('#customer_phone').val(),
                    $('#license_plate').val(),
                    $('#customer_address').val(),
                    $('#workshop-id-hidden').val(),
                    $('#voucher-code-hidden').val(),
                    $('#voucher-discount-hidden').val(),
                    $('#trade-in-discount').val(),
                    $('#final-total').val(),
                    $('.trade_in_type_id'),
                    $('.trade_in_quantity'),
                    $('.trade_in_discount'),
                    $('#agent-id-hidden').val(),
                  ])
                })
              },
              onOpen: function () {
                $('#customer_name').focus()
              }
            }).then(function (result) {
                if (result.isConfirmed) {
                    var condition               = result['value'][0];
                    var customer_name           = result['value'][1];
                    var customer_phone          = result['value'][2];
                    var license_plate           = result['value'][3];
                    var customer_address        = result['value'][4];
                    var workshop_id             = result['value'][5]
                    var voucher_code            = result['value'][6];
                    var voucher_discount        = result['value'][7];
                    var trade_in_total_discount = result['value'][8];
                    var final_total             = result['value'][9];
                    var trade_in_type_id        = extractInputArray(result['value'][10]);
                    var trade_in_quantity       = extractInputArray(result['value'][11]);
                    var trade_in_discount       = extractInputArray(result['value'][12]);
                    var agent_id                = result['value'][13];
                    var partner_id              = global_partner_id;
                    var cart                    = JSON.parse(sessionStorage.getItem("cart"));
                    var grand_total             = JSON.parse(sessionStorage.getItem("grand_total"));
                    
                    if (partner_id != "0" && condition != "0") {
                        $.post("<?= base_url('CustomerController/place_order') ?>", {
                            condition: condition,
                            customer_name: customer_name,
                            customer_phone: customer_phone,
                            license_plate: license_plate,
                            customer_address: customer_address,
                            workshop_id: workshop_id,
                            voucher_code: voucher_code,
                            voucher_discount: voucher_discount,
                            trade_in_total_discount: trade_in_total_discount,
                            final_total: final_total,
                            trade_in_type_id: trade_in_type_id,
                            trade_in_quantity: trade_in_quantity,
                            trade_in_discount: trade_in_discount,
                            agent_id: agent_id,
                            partner_id: partner_id,
                            cart: cart,
                            grand_total: grand_total,
                        }, function(data, status){
                            var response = JSON.parse(data);
                            var status = response["status"];
                            var billplz_bill_link = response['billplz_bill_link'];
                            var order_id = response['order_id'];
                            var trade_in_id = response['trade_in_id'];

                            if (status == "success") {
                                switch(condition) {
                                    case "1":
                                        window.sessionStorage.removeItem('cart');
                                        swal_order_details(condition, order_id, trade_in_id, "Successfully trade-in your batteries. A driver will come pickup the batteries and partner will transfer the trade-in total of RM " + final_total.slice(1) + " to you. Thank you for trading-in batteries with Bateri Laju!");
                                        break;
                                    case "2":
                                        window.open(billplz_bill_link, "_self");
                                        break;
                                    case "3":
                                        if (parseFloat(final_total) < 0.00) {
                                            window.sessionStorage.removeItem('cart');
                                            swal_order_details(condition, order_id, trade_in_id, "Successfully placed an order. A driver will come pickup the batteries and partner will transfer the remaining trade-in total of RM " + final_total.slice(1) + " to you. Thank you for purchase with Bateri Laju!");
                                        } else {
                                            window.open(billplz_bill_link, "_self");
                                        }
                                        break;
                                }

                                loadCart();
                            } else {
                                swal("error", "center", "Failed to place order. Please try again later.", true, 0, true);
                            }
                        });
                    }
                }
            }).catch(swal.noop);
            
            $('#grand-total-hidden').val(grand_total);
            
            if (cart == null) {
                //$('#final-total-label').text('Amount You Get (RM)');
                $('#notice-area').html('<h6 class="m-0" id="notice-hidden" style="text-align:left; color: #EE0263;">Note: Your cart is empty, if you trade-in batteries now, partner will direct transfer the trade-in amount to you.</h6>');
            }
        }
        
        function swal_order_details(condition, order_id, trade_in_id, title) { // load order details
            $.post("<?= base_url('CustomerController/load_checkout_detail') ?>", {
                trade_in_id: trade_in_id,
                order_id: order_id,
                title: title
            }, function(data, status){
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  html: data,
                  showConfirmButton: true,
                  allowOutsideClick: false,
                  confirmButtonText: 'OK',
                  backdrop: true,
                }).then(function (result) {
                    if (result.isConfirmed) {
                        
                    }
                }).catch(swal.noop);
            });
        }
    </script>
</body>

</html>