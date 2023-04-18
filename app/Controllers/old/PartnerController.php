<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Partner;
use App\Models\Staff;
use App\Models\Commission;
use App\Models\Product;
use App\Models\Partner_Product;
use App\Models\Trade_In;
use App\Models\Trade_In_Item;

class PartnerController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->partnerModel = new Partner();
        $this->staffModel = new Staff();
        $this->commissionModel = new Commission();
        $this->productModel = new Product();
        $this->partnerProductModel = new Partner_Product();
        $this->tradeInModel = new Trade_In();
        $this->tradeInItemModel = new Trade_In_Item();
    }
    
    
	public function index()
	{
		$partners_data = $this->partnerModel->findAll();
        
        // Find batteries to collect from trade-ins
        $i = 0;
        foreach ($partners_data as $partner) {
            $trade_ins = $this->tradeInModel->where(['partner_id' => $partner['id'], 'trade_in_status' => 0])->findAll();
            $battery_to_collect = 0;
            
            foreach($trade_ins as $trade_in) {
                $items = $this->tradeInItemModel->where(['trade_in_id' => $trade_in['trade_in_id'], 'trade_in_status' => 0])->findAll();
                
                foreach ($items as $item) {
                    $battery_to_collect += $item['quantity'];
                }
            }
            
            $partners_data[$i]['battery_to_collect'] = $battery_to_collect;
            $i++;
        }
                
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Partner List']),
			'page_title' => view('partials/page-title', ['title' => 'Partner List', 'li_1' => 'Dashboard', 'li_2' => 'Partner List']),
			'partners_data' => $partners_data,
			'staffs' => $this->staffModel->where('role', 1)->findAll()
		];
		return view('partners/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Partner']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Partner', 'li_1' => 'Dashboard', 'li_2' => 'Partner List', 'li_3' => 'Add New Partner']),
			'staffs' => $this->staffModel->where('role', 1)->orderBy('name', 'ASC')->findAll(),
			'products' => $this->productModel->orderBy('name', 'DESC')->findAll(),
		];

		return view('partners/add-form', $data);
	}

	public function save_add()
	{
		$data = [
		    'staff_id' => $_POST['staff_id'],
		    'email' => $_POST['email'],
		    'password' => $_POST['password'],
			'name' => $_POST['name'],
			'contact_no' => $_POST['contact_no'],
			'adddress' => $_POST['adddress'],
			'pic_name' => $_POST['pic_name'], 
			'pic_phone' => $_POST['pic_phone'], 
			'commission' => $_POST['commission'],
		];

		$this->partnerModel->save($data);
		$partner_id = $this->partnerModel->insertID();
		$product_id = $_POST['product_id'];
		$percentage = $_POST['percentage'];
		
		if (COUNT($product_id) > 0) {
		    for ($i = 0; $i < COUNT($product_id); $i++) {
		        if ($product_id[$i] != "") {
		            $data = [
		                'partner_id' => $partner_id,
		                'product_id' => $product_id[$i],
		                'additional_commission_percentage' => $percentage[$i] ?? 0,
		                'created_at' => $this->datetime,
		            ];
		            
		            $this->partnerProductModel->save($data);
		        }
		    }
		}

		return redirect('partner')->with('status', 'Partner inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Partner']),
			'page_title' => view('partials/page-title', ['title' => 'Update Partner', 'li_1' => 'Dashboard', 'li_2' => 'Partner List', 'li_3' => 'Update Partner']),
			'partner' => $this->partnerModel->find($id),
			'partner_products' => $this->partnerProductModel->where('partner_id', $id)->findAll(),
			'staffs' => $this->staffModel->where('role', 1)->orderBy('name', 'ASC')->findAll(),
			'products' => $this->productModel->orderBy('name', 'ASC')->findAll(),
		];

		return view('partners/edit-form', $data);
	}

	public function save_update($partner_id = null)
	{
	    $data = [
		    'staff_id' => $_POST['staff_id'],
		    'email' => $_POST['email'],
		    'password' => $_POST['password'],
			'name' => $_POST['name'],
			'contact_no' => $_POST['contact_no'],
			'adddress' => $_POST['adddress'],
			'pic_name' => $_POST['pic_name'], 
			'pic_phone' => $_POST['pic_phone'], 
			'commission' => $_POST['commission'],
		];
		$this->partnerModel->update($partner_id, $data);
	    
	    $partner_product_id   = $this->request->getVar('partner_product_id') ?? [];
        $product_id = $_POST['product_id'] ?? [];
		$percentage = $_POST['percentage'] ?? [];

        for ($i = 0; $i < COUNT($product_id); $i++) {
            if (array_key_exists($i, $partner_product_id)) {
                $this->partnerProductModel->update($partner_product_id[$i], [
                    "product_id" => $product_id[$i] ?? "0",
                    "additional_commission_percentage" => $percentage[$i] ?? "0",
                ]);
            } else {
                $this->partnerProductModel->insert([
                    'partner_id' => $partner_id,
	                'product_id' => $product_id[$i] ?? "0",
	                'additional_commission_percentage' => $percentage[$i] ?? 0,
	                'created_at' => $this->datetime,
                ]);
            }
        }
        
        return redirect()->to('/update_partner/'.$partner_id)->with('status', 'Partner updated Successfully'); 
	    
		
		$this->partnerModel->update($id, $data);

		return redirect('partner')->with('status', 'Partner updated Successfully');
	}

	public function delete_Partner($id = null)
	{
		$this->partnerModel->delete($id);
		$this->partnerProductModel->where('partner_id', $id)->delete();

		return redirect('partner')->with('status', 'Partner deleted Successfully');
	}
	
	public function delete_partner_product($partner_id = 0, $partner_product_id = 0) {
	    $this->partnerProductModel->where("partner_product_id", $partner_product_id)->delete();
	    
	    return redirect()->to('/update_partner/'.$partner_id)->with('status', 'Partner updated Successfully'); 
	}
	
	public function commission_withdrawal() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Partner Commission Withdrawal Requests']),
			'page_title' => view('partials/page-title', ['title' => 'Partner Commission Withdrawal Requests', 'li_1' => 'Dashboard', 'li_2' => 'Partner List', 'li_3' => 'Partner Commission Withdrawal Requests']),
			'commissions_data' => $this->commissionModel->join('bs_partners', 'bs_partners.id = bs_commissions.partner_id')->orderBy('bs_commissions.commission_id', 'DESC')->findAll(),
		];

		return view('partners/commission_withdrawal', $data);
	}
	
	public function modify_withdraw_status() {
	    $status = $this->request->getPost('status');
	    $commission_id = $this->request->getPost('commission_id');

        $data = [
            'status' => $status,
        ];
        $update = $this->commissionModel->update($commission_id, $data);
        
        $result = $this->commissionModel->where('commission_id', $commission_id)->findAll();
        if ($update) {
            if ($status == 2 && $result[0]['is_refunded'] == 1) {
                echo json_encode(["status" => "success", "message" => "Status changed successfully, but unable to refund the amount to partner because it has been done before."]);
            } else {
                if ($status == 2) {
                    $amount = $result[0]['amount'];
        	        $partner_id = $result[0]['partner_id'];
                    
                    $this->db->query("UPDATE bs_partners SET commission = commission + $amount WHERE id = '$partner_id'");
                    $this->db->query("UPDATE bs_commissions SET is_refunded = 1 WHERE commission_id = '$commission_id'");
                    
                    echo json_encode(["status" => "success", "message" => "Status changed successfully, and refunded the amount to partner."]);
                } else {
                    echo json_encode(["status" => "success", "message" => "Status changed successfully."]);
                }
            }
        } else {
            echo json_encode(["error" => "error", "message" => "Failed to change status."]);
        }
	}
	
	public function delete_commission_withdrawal($id = null)
	{
	    $result = $this->commissionModel->where('commission_id', $id)->findAll();
	    
	    if ($result[0]['status'] == 2) {
	        return redirect('commission_withdrawal')->with('status', 'Invalid request, this commission withdrawal request has been cancelled before.');
	    } else {
	        $amount = $result[0]['amount'];
	        $partner_id = $result[0]['partner_id'];
	        
	        $delete = $this->commissionModel->delete($id);
	        $this->db->query("UPDATE bs_commissions SET is_refunded = 1 WHERE commission_id = '$id'");
	        
	        if ($delete) {
	            $this->db->query("UPDATE bs_partners SET commission = commission + $amount WHERE id = '$partner_id'");
	            return redirect('commission_withdrawal')->with('status', 'Commission withdrawal request deleted Successfully');
	        } else {
	            return redirect('commission_withdrawal')->with('status', 'Failed to delete the commission withdrawal request, refund has not been made to the partner.');
	        }
	    }
	}
	
	public function base_commission() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Partner Base Commission Rate']),
			'page_title' => view('partials/page-title', ['title' => 'Update Partner Base Commission Rate', 'li_1' => 'Dashboard', 'li_2' => 'Update Partner Base Commission Rate']),
			'base_commission' => $this->db->query("SELECT * FROM bs_commissions_rates ORDER BY commission_rate_id DESC LIMIT 1")->getResultArray()[0]['base_rate'],
		];

		return view('partners/base-commission', $data);
	}
	
	public function update_base_commission() {
	    $base_rate = $this->request->getPost('base_rate');

	    $result = $this->db->query("UPDATE bs_commissions_rates SET base_rate = '$base_rate'");
	    
	    if ($result) {
	        return redirect('base_commission')->with('status', 'Successfully updated the partner base commission rate.');
	    } else {
	        return redirect('base_commission')->with('status', 'Failed to update the partner base commission rate.');
	    }
	}
}
