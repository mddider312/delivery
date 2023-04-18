<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Trade_In;
use App\Models\Trade_In_Item;
use App\Models\Trade_In_Type;
use App\Models\Partner;
use App\Models\Staff;

class TradeInController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->tradeInModel = new Trade_In();
        $this->tradeInItemModel = new Trade_In_Item();
        $this->tradeInTypeModel = new Trade_In_Type();
        $this->partnerModel = new Partner();
        $this->staffModel = new Staff();
    }
    
	public function index() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Trade-In Battery List']),
			'page_title' => view('partials/page-title', ['title' => 'Trade-In Battery List', 'li_1' => 'Dashboard', 'li_2' => 'Trade-In Battery List']),
			'trade_ins' => $this->tradeInModel->orderBy('trade_in_id', "DESC")->findAll(),
			'trade_in_types' => $this->tradeInTypeModel->findAll(),
			'partners' => $this->partnerModel->findAll(),
			'drivers' => $this->staffModel->where('role = 2')->findAll(),
		];

		return view('trade-ins/index', $data);
	}
	
	public function trade_in_type() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Set Trade-In Battery Type']),
			'page_title' => view('partials/page-title', ['title' => 'Set Trade-In Battery Type', 'li_1' => 'Dashboard', 'li_2' => 'Set Trade-In Battery Type']),
			'trade_in_types' => $this->tradeInTypeModel->findAll()
		];
		
		return view('trade-ins/trade-in-type', $data);
	}
	
	/*
	public function update_field() {
	    $trade_in_id = $this->request->getPost('id');
	    $data = $this->request->getPost('data');
	    $field = $this->request->getPost('field');
	    
	    $result = $this->tradeInModel->set(["$field" => "$data"])->where('trade_in_id', $trade_in_id)->update();
	    
	    if ($result) {
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
	*/
	
	public function update_trade_in_driver() {
	    $trade_in_id = $this->request->getPost('trade_in_id');
	    $staff_id = $this->request->getPost('staff_id');
	    
	    $result = $this->tradeInModel->set(['staff_id' => $staff_id])->where('trade_in_id', $trade_in_id)->update();
	    
	    if ($result) {
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
	
	public function update_trade_in_status() {
	    $trade_in_id = $this->request->getPost('trade_in_id');
	    $trade_in_status = $this->request->getPost('trade_in_status');
	    
	    $result = $this->tradeInModel->set(['trade_in_status' => $trade_in_status])->where('trade_in_id', $trade_in_id)->update();
	    
	    if ($result) {
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
	
	public function update_trade_in_payment() {
	    $trade_in_id = $this->request->getPost('trade_in_id');
	    $payment_status = $this->request->getPost('payment_status');
	    
	    $result = $this->tradeInModel->set(['payment_status' => $payment_status])->where('trade_in_id', $trade_in_id)->update();
	    
	    if ($result) {
	        echo "success";
	    } else {
	        echo "failed";
	    }
	}
	
	public function update_trade_in_type() {
	    $trade_in_type_id = $this->request->getPost('trade_in_type_id');
	    $type = $this->request->getPost('type');
	    $value_with_order = $this->request->getPost('value_with_order');
	    $value_without_order = $this->request->getPost('value_without_order');
	    
	    for ($i = 0; $i < COUNT($type); $i++) {
	        if (array_key_exists($i, $trade_in_type_id)) {
	            $data = [
	                'type' => $type[$i],
	                'value_with_order' => $value_with_order[$i],
	                'value_without_order' => $value_without_order[$i],
	            ];
	            
	            $this->tradeInTypeModel->update($trade_in_type_id[$i], $data);
	        } else {
	            $data = [
	                'type' => $type[$i],
	                'value_with_order' => $value_with_order[$i],
	                'value_without_order' => $value_without_order[$i],
	                'created_at' => $this->datetime,
	            ];
	            
	            $this->tradeInTypeModel->save($data);
	        }
	    }
	    
	    return redirect('trade_in_type')->with('status', 'Battery trade-in type updated successfully');
	}
	
	public function delete_trade_in_type($id = 0) {
	    $delete = $this->tradeInTypeModel->where('trade_in_type_id', $id)->delete();
	    
	    if ($delete) {
	        return redirect('trade_in_type')->with('status', 'Battery trade-in type deleted successfully');
	    } else {
	        return redirect('trade_in_type')->with('status', 'Failed to delete the battery trade-in type');
	    }
	}
}
