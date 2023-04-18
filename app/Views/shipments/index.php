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
                                    <?php 
                                        if ($shipment_type == "pickup") {
                                    ?>
                                            <div class="float-end font-size-16">
                                                <a href="<?= $shipment_type == "pickup" ? "/pickup_add" : "/dropoff_add" ?>" class="btn font-16 btn-primary" id="">
                                                    <i class="mdi mdi-plus-circle-outline"></i> 
                                                    <?= $shipment_type == "pickup" ? "Add New Pickup" : "Add New Dropoff" ?>
                                                </a>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                    
                                    <h4 class="card-title mb-4"><?= $title ?></h4>
                                </div>
                                <br>
                                <?= $this->include('partials/alert') ?>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="pictureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Shipment Complete Pictures (Shipment No: <span id="pictureModal-shipment_no"></span>) (Pictures: <span id="pictureModal-picture_count"></span>)</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body" id="pictureModal-picture_list">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center"><?= lang('Actions') ?></th>
                                                <th class="text-center"><?= lang('Shipment') ?></th>
                                                <th class="text-center"><?= lang('Sender') ?></th>
                                                <th class="text-center"><?= lang('Receiver') ?></th>
                                                <th class="text-center"><?= lang('Created At') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;

                                                foreach ($shipments as $data) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <div class="btn-group-vertical w-100">
                                                                <div class="btn-group">
                                                                    <select class="form-control w-100 btn btn-<?= $data['driver'] == "" ? "danger" : "primary"; ?> btn-sm font-size-14" id="shipment-driver-btn-<?= $data['id'] ?>" value="<?= $data['id'] ?? '' ?>" onchange="updateShipmentDriver('<?= $data['id'] ?>', this.value);"
                                                                          data-bs-toggle="tooltip" data-bs-placement="top" title="Driver">
                                                                        <option hidden>-- PLEASE SELECT --</option>
                                                                        <?php
                                                                            $delivery_partner_name = "";
                                                                        
                                                                            foreach ($drivers as $d) {
                                                                        ?>
                                                                                <option value="<?= $d['id'] ?>" <?= $d['id'] == $data['driver'] ? 'selected' : '' ?>><?= $d['name'] ?></option>
                                                                        <?php
                                                                                if ($d['id'] == $data['delivery_partner']) {
                                                                                    $delivery_partner_name = $d['name'];
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                    <div class="dropdown">
                                                                        <?php
                                                                            $pic1 = explode(",", $data['pickup_picture']);
                                                                            $pic2 = explode(",", $data['drop_picture']);
                                                                            
                                                                            $pic3 = array_unique(array_merge($pic1, $pic1));
                                                                            
                                                                            $pic = implode(",", $pic3);
                                                                            
                                                                            /*
                                                                            switch($shipment_type) {
                                                                                case "pickup":
                                                                                    $pic = $data['pickup_picture'];
                                                                                    break;
                                                                                case "dropoff":
                                                                                    $pic = $data['drop_picture'];
                                                                                    break;
                                                                            }
                                                                            */
                                                                        ?>
                                                                      <button class="w-auto btn btn-info btn-sm font-size-14" type="button" id="picture-<?= $data['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Shipment Complete Pictures" onclick="togglePictureModal('<?= $data['shipment_no'] ?>', '<?= $pic ?>');">
                                                                        <i class="fa fa-eye"></i>
                                                                      </button>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    if ($data['delivery_partner'] != "") {
                                                                ?>
                                                                        <br>
                                                                        <button class="w-100 btn btn-primary btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Delivery Partner">
                                                                            <?= $delivery_partner_name ?>
                                                                        </button>
                                                                <?php
                                                                    }
                                                                ?>
                                                                <br>
                                                                
                                                                <?php
                                                                    $shipment_status = "";
                                                                    $color = "";
                                                                    switch ($data['shipment_status']) {
                                                                        case "0":
                                                                            /*
                                                                            $shipment_status = '
                                                                                <div class="btn-group">
                                                                                    <button class="w-100 btn btn-outline-primary btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-1-'.$data['id'].'">Info Received</button>
                                                                            ';
                                                                            break;
                                                                            */
                                                                        case "1":
                                                                            $color = "warning";
                                                                            $shipment_status = '
                                                                                <div class="btn-group">
                                                                                    <button class="w-auto btn btn-primary btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-1-'.$data['id'].'"><b>PICKUP</b></button>
                                                                                    <button class="w-auto btn btn-warning btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-2-'.$data['id'].'"><b>PENDING</b></button>
                                                                            ';
                                                                            break;
                                                                        case "2":
                                                                            $color = "success";
                                                                            $shipment_status = '
                                                                                <div class="btn-group">
                                                                                    <button class="w-auto btn btn-primary btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-1-'.$data['id'].'"><b>PICKUP</b></button>
                                                                                    <button class="w-auto btn btn-success btn-sm font-size-14 p-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-2-'.$data['id'].'"><b>DONE</b></button>
                                                                            ';
                                                                            break;
                                                                        case "3":
                                                                            $color = "warning";
                                                                            $shipment_status = '
                                                                                <div class="btn-group">
                                                                                    <button class="w-auto btn btn-danger btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-1-'.$data['id'].'"><b>DROP</b></button>
                                                                                    <button class="w-auto btn btn-warning btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-2-'.$data['id'].'"><b>PENDING</b></button>
                                                                            ';
                                                                            break;
                                                                        case "4":
                                                                            $color = "success";
                                                                            $shipment_status = '
                                                                                <div class="btn-group">
                                                                                    <button class="w-auto btn btn-danger btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-1-'.$data['id'].'"><b>DROP</b></button>
                                                                                    <button class="w-auto btn btn-success btn-sm font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Status" id="status-2-'.$data['id'].'"><b>DONE</b></button>
                                                                            ';
                                                                            break;
                                                                    }
                                                                    /*<li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 0)">INFO RECEIVED</a></li>
                                                                                <li><hr class="dropdown-divider"></li>*/
                                                                                
                                                                    switch($shipment_type) {
                                                                        case "pickup":
                                                                            $shipment_status .= '
                                                                                    <div class="dropdown">
                                                                                      <button class="w-auto btn btn-'.$color.' btn-sm font-size-14 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="status-3-'.$data['id'].'">
                                                                                        <i class="fa fa-edit"></i>
                                                                                      </button>
                                                                                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                                        
                                                                                        <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 1)">PICKUP PENDING</a></li>
                                                                                        <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 2)">PICKUP DONE</a></li>
                                                                                      </ul>
                                                                                    </div>
                                                                                </div>
                                                                            ';
                                                                            break;
                                                                        case "dropoff":
                                                                            $shipment_status .= '
                                                                                    <div class="dropdown">
                                                                                      <button class="w-auto btn btn-'.$color.' btn-sm font-size-14 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="status-3-'.$data['id'].'">
                                                                                        <i class="fa fa-edit"></i>
                                                                                      </button>
                                                                                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                                        <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 3)">DROP PENDING</a></li>
                                                                                        <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 4)">DROP DONE</a></li>
                                                                                      </ul>
                                                                                    </div>
                                                                                </div>
                                                                            ';
                                                                            break;
                                                                    }
                                                                    /*
                                                                    $shipment_status .= '
                                                                            <div class="dropdown">
                                                                              <button class="w-auto btn btn-'.$color.' btn-sm font-size-14 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="status-3-'.$data['id'].'">
                                                                                <i class="fa fa-edit"></i>
                                                                              </button>
                                                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                                
                                                                                <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 1)">PICKUP PENDING</a></li>
                                                                                <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 2)">PICKUP DONE</a></li>
                                                                                <li><hr class="dropdown-divider"></li>
                                                                                <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 3)">DROP PENDING</a></li>
                                                                                <li><a class="dropdown-item" href="#" onclick="setShipmentStatus('.$data['id'].', 4)">DROP DONE</a></li>
                                                                              </ul>
                                                                            </div>
                                                                        </div>
                                                                    ';
                                                                    */
                                                                    
                                                                    echo $shipment_status;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <span data-bs-toggle='tooltip' data-bs-placement='top' title='Shipment No.'><b><?= $data["shipment_no"] ?></b></span>
                                                                    <br>
                                                                    
                                                                    <span data-bs-toggle='tooltip' data-bs-placement='top' title='Shipment Group' style='font-size: 12px;'><?= $data["shipment_group"] ?></span>
                                                                    <br>
                                                                    
                                                                    <?php
                                                                        if ($data['quantity'] != null) {
                                                                    ?>
                                                                            <span data-bs-toggle='tooltip' data-bs-placement='top' title='Shipment Quantity' style='font-size: 12px;'><?= $data["quantity"]." pcs" ?></span>
                                                                            <br>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                            
                                                                    <span data-bs-toggle='tooltip' data-bs-placement='top' title='Driver Commission' style='font-size: 12px;'><?= "RM ".$data["driver_commission"] ?></span>
                                                                    &ensp;
                                                                    <i class="fa fa-edit" onclick="editCommission('driver', '<?= $data['id'] ?>')"></i>
                                                                    <br>
                                                                    
                                                                    <?php
                                                                        if ($data['delivery_partner'] != "") {
                                                                    ?>
                                                                            <b style='font-size: 12px;' data-bs-toggle="tooltip" data-bs-placement="top" title="Delivery Partner Commission" id="delivery-partner-commission-<?= $data['id'] ?>">RM <?= $data['delivery_partner_commission'] ?></b>&ensp;
                                                                            <i class="fa fa-edit" onclick="editCommission('partner', '<?= $data['id'] ?>')"></i>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= "<b>$data[sender_name] ($data[sender_phone])</b><br>
                                                                        <span style='font-size: 12px;'>$data[sender_email]<br>
                                                                        $data[sender_address_line1], $data[sender_address_line2],<br>$data[sender_state], $data[sender_city], $data[sender_postcode], $data[sender_country]</span>"; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= "<b>$data[receiver_name] ($data[receiver_phone])</b><br>
                                                                        <span style='font-size: 12px;'>$data[receiver_email]<br>
                                                                        $data[receiver_address_line1], $data[receiver_address_line2],<br>$data[receiver_state], $data[receiver_city], $data[receiver_postcode], $data[receiver_country]</span>"; ?>
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="text-truncate font-size-14 m-0">
                                                                <a href="javascript: void(0);" class="text-dark">
                                                                    <?= str_replace(" ", "<br>", $data['created_at']) ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var drivers = <?= json_encode($drivers) ?>;

    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: true,
        });
    });
    
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
    
    function togglePictureModal(shipment_no, pictures) {
        $('#pictureModal').modal('show');
        $('#pictureModal-shipment_no').text(shipment_no);
        
        if (pictures == "") {
            $('#pictureModal-picture_count').text("0");
            $('#pictureModal-picture_list').text("n/a");
        } else {
            var html = `<div class="row">`;
            
            var p_list = pictures.split(",");
            $('#pictureModal-picture_count').text(p_list.length);
            
            for (var i = 0; i < p_list.length; i++) {
                var img_str = `
                    <div class="col-6">
                        <img src="<?= base_url("uploads/mobile_app/images/shipment") ?>/` + p_list[i] + `" style="width:100%;">
                    </div>
                `;
                
                html += img_str;
            }
            
            $('#pictureModal-picture_list').html(html + "</div>");
        }
    }
    
    function editCommission(type, shipment_id) {
        var message = type == "driver" ? "Edit Driver Commission" : "Edit Delivery Partner Commission";
        
        let new_commission = prompt(message);

        if (new_commission.length != 0 && new_commission != null && new_commission != "" && !isNaN(new_commission)) {
            $.post("<?= base_url('ShipmentController/edit_shipment_commission') ?>", {
                shipment_id: shipment_id,
                type: type,
                new_commission: new_commission,
            }, function(data, status){
                if (data == "success") {
                    switch (type) {
                        case "driver":
                            $("#driver-commission-" + shipment_id).text("RM " + parseFloat(new_commission).toFixed(2));
                            break;
                        case "partner":
                            $("#delivery-partner-commission-" + shipment_id).text("RM " + parseFloat(new_commission).toFixed(2));
                            break;
                    }
                    
                    swal("success", "top-start", "Successfully set shipment status.", false, 1000, false);
                } else {
                    swal("error", "top-start", "Failed to set shipment status.", false, 1000, false);
                }
            });
        } else {
            alert("Please key in numbers only.");
        }
    }
    
    function setShipmentStatus(shipment_id, shipment_status) {
        $.post("<?= base_url('ShipmentController/update_shipment_status') ?>", {
            shipment_id: shipment_id,
            shipment_status: shipment_status,
        }, function(data, status){
            if (data == "success") {
                var btn1 = document.getElementById("status-1-" + shipment_id);
                var btn2 = document.getElementById("status-2-" + shipment_id);
                var btn3 = document.getElementById("status-3-" + shipment_id);
                
                switch (shipment_status) {
                    case 0:
                    case 1:
                        btn1.className = "w-auto btn btn-primary btn-sm font-size-14";
                        btn2.className = "w-auto btn btn-warning btn-sm font-size-14";
                        btn1.innerHTML = "<b>PICKUP</b>";
                        btn2.innerHTML = "<b>PENDING</b>";
                        btn3.className = "w-auto btn btn-warning btn-sm font-size-14 dropdown-toggle";
                        break;
                    case 2:
                        btn1.className = "w-auto btn btn-primary btn-sm font-size-14";
                        btn2.className = "w-auto btn btn-success btn-sm font-size-14";
                        btn1.innerHTML = "<b>PICKUP</b>";
                        btn2.innerHTML = "<b>DONE</b>";
                        btn3.className = "w-auto btn btn-success btn-sm font-size-14 dropdown-toggle";
                        break;
                    case 3:
                        btn1.className = "w-auto btn btn-danger btn-sm font-size-14";
                        btn2.className = "w-auto btn btn-warning btn-sm font-size-14";
                        btn1.innerHTML = "<b>DROP</b>";
                        btn2.innerHTML = "<b>PENDING</b>";
                        btn3.className = "w-auto btn btn-warning btn-sm font-size-14 dropdown-toggle";
                        break;
                    case 4:
                        btn1.className = "w-auto btn btn-danger btn-sm font-size-14";
                        btn2.className = "w-auto btn btn-success btn-sm font-size-14";
                        btn1.innerHTML = "<b>DROP</b>";
                        btn2.innerHTML = "<b>DONE</b>";
                        btn3.className = "w-auto btn btn-success btn-sm font-size-14 dropdown-toggle";
                        break;
                }
                
                swal("success", "top-start", "Successfully set shipment status.", false, 1000, false);
            } else {
                swal("error", "top-start", "Failed to set shipment status.", false, 1000, false);
            }
        });
    }
    
    function updateShipmentDriver(shipment_id, driver_id) {
        $.post("<?= base_url('ShipmentController/update_shipment_driver') ?>", {
            shipment_id: shipment_id,
            driver_id: driver_id,
        }, function(data, status){
            if (data == "success") {
                var driver_name = "";
                
                for (var i = 0; i < drivers.length; i++) {
                    if (drivers[i]['id'] == driver_id) {
                        $("#shipment-driver-btn-" + shipment_id).removeClass("btn-danger").addClass("btn-primary");
                    }
                }
                
                swal("success", "top-start", "Successfully assigned driver.", false, 1000, false);
            } else {
                swal("error", "top-start", "Failed to assign driver.", false, 1000, false);
            }
        });
    }
</script>

</body>

</html>