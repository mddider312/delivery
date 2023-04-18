<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commission_Type;

class CommissionController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->commissionTypeModel = new Commission_Type();
    }
    
	public function commission_type() {
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Set Commission Types']),
			'page_title' => view('partials/page-title', ['title' => 'Set Commission Types', 'li_1' => 'Dashboard', 'li_2' => 'Master', 'li_3' => 'Set Commission Types']),
			'commission_types' => $this->commissionTypeModel->findAll()
		];
		return view('commission/commission-type', $data);
	}
	
	public function update_commission_type() {
	    $commission_type_id = $this->request->getPost('commission_type_id');
	    $type = $this->request->getPost('type');
	    $percentage = $this->request->getPost('percentage');
	    
	    for ($i = 0; $i < COUNT($type); $i++) {
	        if ($commission_type_id == "") {
	            $data = [
	                'type' => $type[$i],
	                'percentage' => $percentage[$i],
	                'created_at' => $this->datetime,
	            ];
	            
	            $this->commissionTypeModel->save($data);
	        } else {
	            if (array_key_exists($i, $commission_type_id)) {
    	            $data = [
    	                'type' => $type[$i],
    	                'percentage' => $percentage[$i],
    	            ];
    	            
    	            $this->commissionTypeModel->update($commission_type_id[$i], $data);
    	        } else {
    	            $data = [
    	                'type' => $type[$i],
    	                'percentage' => $percentage[$i],
    	                'created_at' => $this->datetime,
    	            ];
    	            
    	            $this->commissionTypeModel->save($data);
    	        }
	        }
	    }
	    
	    return redirect('commission_type')->with('status', 'Commission type updated successfully');
	}
	
	public function delete_commission_type($id = 0) {
	    $delete = $this->commissionTypeModel->where('commission_type_id', $id)->delete();
	    
	    if ($delete) {
	        return redirect('commission_type')->with('status', 'Commission type deleted successfully');
	    } else {
	        return redirect('commission_type')->with('status', 'Failed to delete the commission type');
	    }
	}
}

