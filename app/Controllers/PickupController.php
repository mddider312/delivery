<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Shipment;
use App\Models\Staff;

class PickupController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->shipmentModel = new Shipment();
        $this->staffModel = new Staff();
    }

	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Pickup Shipments']),
			'page_title' => view('partials/page-title', ['title' => 'Pickup Shipments', 'li_1' => 'Dashboard', 'li_2' => 'Pickup Shipments']),
			'shipments' => $this->shipmentModel->where("shipment_status = 0 OR shipment_status = 1 OR shipment_status = 2")->orderBy('id ', 'DESC')->findAll(),
			'drivers' => $this->staffModel->where("role", 2)->findAll(),
		];
		
		return view('shipments/index', $data);
	}
	
	public function update_shipment_driver() {
	    $shipment_id = $this->request->getVar("shipment_id");
	    $driver_id = $this->request->getVar("driver_id");
	    
	    $result = $this->shipmentModel->update($shipment_id, ["driver" => $driver_id]);
	    
	    if ($result) {
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
	
	public function update_shipment_status() {
	    $shipment_id = $this->request->getVar("shipment_id");
	    $shipment_status = $this->request->getVar("shipment_status");
	    
	    $result = $this->shipmentModel->update($shipment_id, ["shipment_status" => $shipment_status]);
	    
	    if ($result) {
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
	
	public function edit_shipment_commission() {
	    $shipment_id = $this->request->getVar("shipment_id");
	    $new_commission = $this->request->getVar("new_commission");
	    $type = $this->request->getVar("type");
	    
	    $role = "";
	    if ($type == "driver") {
	        $role = 0;
	        $result = $this->shipmentModel->update($shipment_id, ["driver_commission" => $new_commission]);
	    } else if ($type == "partner") {
	        $role = 1;
	        $result = $this->shipmentModel->update($shipment_id, ["delivery_partner_commission" => $new_commission]);
	    }
	    
	    if ($result) {
	        $this->db->query("UPDATE bs_shipments_commissions SET commission = '$new_commission' WHERE shipment_id = '$shipment_id' AND role = '$role'");
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
}
