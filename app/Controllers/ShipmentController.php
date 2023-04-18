<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Shipment;
use App\Models\Staff;
use App\Models\Api_Credential;

class ShipmentController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->shipmentModel = new Shipment();
        $this->staffModel = new Staff();
        $this->apiCredentialModel = new Api_Credential();
        
        // API
        // Live        
        $this->api_url = "https://api.brightstar.com.my/api/v1";
        $this->environment = 1;
        
        // Sandbox
        $this->api_url = "https://sandbox-api.brightstar.com.my/api/v1";
        $this->environment = 0;
    }
    
    public function getAllShipment() {
        //////////////////////////// Login Start
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->whatsappToken, 'Content-Type: application/json'));
        $credential = $this->apiCredentialModel->where("environment", $this->environment)->findAll()[0];
        $email = $credential['email'];
        $password = $credential['password'];
        $access_token = $credential['access_token'];
        $expired_at = $credential['expired_at'];
        
        if ($access_token == "" || $this->datetime > $expired_at) {
            $datetime = $this->datetime;
            $timestamp = strtotime($datetime) + 60*60*48;
            $new_expire_datetime = date('Y-m-d H:i:s', $timestamp);
            
            $url = $this->api_url."/auth/login";
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $data = array(
                "identity" => $email,
                "password" => $password
            );
            
            $fields_string = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
            
            $resp = curl_exec($curl);
            curl_close($curl);
            
            $response = json_decode($resp);
            $access_token = $response->access_token;
            
            $this->apiCredentialModel->set([
                "access_token" => $access_token,
                "expired_at" => $new_expire_datetime,
            ])->where(["environment" => $this->environment, "email" => $email, "password" => $password])->update();
        }
        //////////////////////////// Login End
    }
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dropoff Shipments']),
			'page_title' => view('partials/page-title', ['title' => 'Dropoff Shipments', 'li_1' => 'Dashboard', 'li_2' => 'Dropoff Shipments']),
			'shipments' => $this->shipmentModel->where("shipment_status = 3 OR shipment_status = 4")->orderBy('id ', 'DESC')->findAll(),
			'drivers' => $this->staffModel->where("role", 2)->findAll(),
			'shipment_type' => 'dropoff'
		];
		
		return view('shipments/index', $data);
	}
	
	public function pickup()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Pickup Shipments']),
			'page_title' => view('partials/page-title', ['title' => 'Pickup Shipments', 'li_1' => 'Dashboard', 'li_2' => 'Pickup Shipments']),
			'shipments' => $this->shipmentModel->where("shipment_status = 0 OR shipment_status = 1 OR shipment_status = 2")->orderBy('id ', 'DESC')->findAll(),
			'drivers' => $this->staffModel->where("role", 2)->findAll(),
			'shipment_type' => 'pickup'
		];
		
		return view('shipments/index', $data);
	}
	
	public function add_pickup_form() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Pickup']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Pickup', 'li_1' => 'Dashboard', 'li_2' => 'Pickup Shipments', 'li_3' => 'Add New Pickup']),
			'drivers' => $this->staffModel->where("role", 2)->findAll(),
			'shipment_type' => 'pickup'
		];
		
		return view('shipments/add-form', $data);
	}
	
	public function save_add() {
	    $shipment_type = $this->request->getVar("shipment_type");
	    $shipment_no = $this->request->getVar("shipment_no");
	    $driver = $this->request->getVar("driver");
	    $shipment_group = $this->request->getVar("shipment_group");
	    $weight = $this->request->getVar("weight");
	    $driver_commission = $this->request->getVar("driver_commission");
	    $sender_name = $this->request->getVar("sender_name");
	    $sender_email = $this->request->getVar("sender_email");
	    $sender_phone = $this->request->getVar("sender_phone");
	    $sender_country = $this->request->getVar("sender_country");
	    $sender_address_line1 = $this->request->getVar("sender_address_line1");
	    $sender_address_line2 = $this->request->getVar("sender_address_line2");
	    $sender_postcode = $this->request->getVar("sender_postcode");
	    $sender_city = $this->request->getVar("sender_city");
	    $sender_state = $this->request->getVar("sender_state");
	    $receiver_name = $this->request->getVar("receiver_name");
	    $receiver_email = $this->request->getVar("receiver_email");
	    $receiver_phone = $this->request->getVar("receiver_phone");
	    $receiver_country = $this->request->getVar("receiver_country");
	    $receiver_address_line1 = $this->request->getVar("receiver_address_line1");
	    $receiver_address_line2 = $this->request->getVar("receiver_address_line2");
	    $receiver_postcode = $this->request->getVar("receiver_postcode");
	    $receiver_city = $this->request->getVar("receiver_city");
	    $receiver_state = $this->request->getVar("receiver_state");
	    $shipment_status = $shipment_type == "pickup" ? 1 : 3;
	    $origin = $sender_state;
	    $destination = $receiver_state;
	    $location = $sender_state;
	    $receiver_address = $receiver_address_line1.", ".$receiver_address_line2;
	    
	    $result = $this->shipmentModel->save([
	        "shipment_no" => $shipment_no,
	        "driver" => $driver,
	        "shipment_group" => $shipment_group,
	        "weight" => $weight,
	        "driver_commission" => $driver_commission,
	        "sender_name" => $sender_name,
	        "sender_email" => $sender_email,
	        "sender_phone" => $sender_phone,
	        "sender_country" => $sender_country,
	        "sender_address_line1" => $sender_address_line1,
	        "sender_address_line2" => $sender_address_line2,
	        "sender_postcode" => $sender_postcode,
	        "sender_city" => $sender_city,
	        "sender_state" => $sender_state,
	        "receiver_name" => $receiver_name,
	        "receiver_email" => $receiver_email,
	        "receiver_phone" => $receiver_phone,
	        "receiver_country" => $receiver_country,
	        "receiver_address_line1" => $receiver_address_line1,
	        "receiver_address_line2" => $receiver_address_line2,
	        "receiver_postcode" => $receiver_postcode,
	        "receiver_city" => $receiver_city,
	        "receiver_state" => $receiver_state,
	        "shipment_status" => $shipment_status,
	        "origin" => $origin,
	        "destination" => $destination,
	        "location" => $location,
	        "receiver_address" => $receiver_address,
	        "created_at" => $this->datetime,
	    ]);
	                    
        if ($result) {
            switch($shipment_type) {
                case "pickup":
                    return redirect('pickup')->with('status', 'Pickup Shipment Added Successfully');
                    break;
                case "dropoff":
                    return redirect('shipment')->with('status', 'Dropoff Shipment Added Successfully');
                    break;
            }
        } else {
            switch($shipment_type) {
                case "pickup":
                    return redirect('pickup_add')->with('status', 'Failed to add pickup shipment.')->withInput();
                    break;
                case "dropoff":
                    return redirect('shipment_add')->with('status', 'Failed to add dropoff shipment.')->withInput();
                    break;
            }
        }
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

    /*
	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Announcement']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Announcement', 'li_1' => 'Dashboard', 'li_2' => 'Announcement List', 'li_3' => 'Add New Announcement']),
		];

		return view('announcements/add-form', $data);
	}

	public function save_add()
	{
	    $img        = $this->request->getFile('photo') ?? null;
	    $image_name = "";
	    
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            
            if ($img->move(ROOTPATH . 'public/uploads/announcements', $newName)) {
                $image_name = $newName;
            }
        }
	    
		$data = [
		    'photo' => $image_name,
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'created_at' => $this->datetime,
		];

		$result = $this->announcementModel->save($data);
        
        if ($result) {
            return redirect('announcement')->with('status', 'Announcement inserted Successfully');
        } else {
            return redirect('announcement')->with('status', 'Failed to insert announcement');
        }
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Announcement']),
			'page_title' => view('partials/page-title', ['title' => 'Update Announcement', 'li_1' => 'Dashboard', 'li_2' => 'Announcement List', 'li_3' => 'Update Announcement']),
			'announcement' => $this->announcementModel->find($id),
		];

		return view('announcements/edit-form', $data);
	}

	public function save_update($id = null)
	{
	    $img        = $this->request->getFile('photo') ?? null;
	    $image_name = "";
	    
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            
            if ($img->move(ROOTPATH . 'public/uploads/announcements', $newName)) {
                $image_name = $newName;
            }
        }
	    
		$data = [
		    'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
		];
		
		if ($image_name != "") {
		    $data['photo'] = $image_name;
		}
		
		$this->announcementModel->update($id, $data);

		return redirect('announcement')->with('status', 'Announcement updated Successfully');
	}

	public function delete_Announcement($id = null)
	{
		$this->announcementModel->delete($id);

		return redirect('announcement')->with('status', 'Announcement deleted Successfully');
	}
	
	public function delete_announcement_photo($id = null)
	{
		$this->announcementModel->update($id, [
		    'photo' => null
		]);
		
		return redirect()->back()->with('status', 'Announcement photo deleted Successfully');
	}
	*/
}
