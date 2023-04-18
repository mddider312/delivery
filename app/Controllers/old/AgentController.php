<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Agent;
use App\Models\Agent_Product;
use App\Models\Product;
use App\Models\Commission;

class AgentController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->agentModel = new Agent();
        $this->agentProductModel = new Agent_Product();
        $this->productModel = new Product();
        $this->commissionModel = new Commission();
    }
    
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Agent List']),
			'page_title' => view('partials/page-title', ['title' => 'Agent List', 'li_1' => 'Dashboard', 'li_2' => 'Agent List']),
			'agents_data' => $this->agentModel->orderBy('agent_id', 'DESC')->findAll(),
		];
		return view('agents/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Agent']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Agent', 'li_1' => 'Dashboard', 'li_2' => 'Agent List', 'li_3' => 'Add New Agent']),
			'products' => $this->productModel->orderBy('name', 'ASC')->findAll(),
		];

		return view('agents/add-form', $data);
	}

	public function save_add()
	{
		$data = [
		    'email' => $_POST['email'],
		    'password' => $_POST['password'],
			'name' => $_POST['name'],
			'contact_no' => $_POST['contact_no'],
			'commission' => $_POST['commission'],
			"created_at" => $this->datetime
		];

		$this->agentModel->save($data);
		$agent_id = $this->agentModel->insertID();
		$product_id = $_POST['product_id'];
		$percentage = $_POST['percentage'];
		
		if (COUNT($product_id) > 0) {
		    for ($i = 0; $i < COUNT($product_id); $i++) {
		        if ($product_id[$i] != "") {
		            $data = [
                        'agent_id' => $agent_id,
		                'product_id' => $product_id[$i],
		                'additional_commission_percentage' => $percentage[$i] ?? 0,
		                'created_at' => $this->datetime,
		            ];
		            
		            $this->agentProductModel->save($data);
		        }
		    }
		}

		return redirect('agent')->with('status', 'Agent inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Agent']),
			'page_title' => view('partials/page-title', ['title' => 'Update Agent', 'li_1' => 'Dashboard', 'li_2' => 'Agent List', 'li_3' => 'Update Agent']),
			'agent' => $this->agentModel->find($id),
			'agent_products' => $this->agentProductModel->where('agent_id', $id)->findAll(),
			'products' => $this->productModel->orderBy('name', 'DESC')->findAll(),
		];

		return view('agents/edit-form', $data);
	}

	public function save_update($agent_id = null)
	{
	    $data = [
		    'email' => $this->request->getVar('email'),
		    'password' => $this->request->getVar('password'),
			'name' => $this->request->getVar('name'),
			'contact_no' => $this->request->getVar('contact_no'),
			'commission' => $this->request->getVar('commission'),
		];
		$this->agentModel->update($agent_id, $data);
	    
	    $agent_product_id   = $this->request->getVar('agent_product_id') ?? [];
        $product_id = $_POST['product_id'] ?? [];
		$percentage = $_POST['percentage'] ?? [];

        for ($i = 0; $i < COUNT($product_id); $i++) {
            if (array_key_exists($i, $agent_product_id)) {
                $this->agentProductModel->update($agent_product_id[$i], [
                    "product_id" => $product_id[$i] ?? "0",
                    "additional_commission_percentage" => $percentage[$i] ?? "0",
                ]);
            } else {
                $this->agentProductModel->insert([
                    'agent_id' => $agent_id,
	                'product_id' => $product_id[$i] ?? "0",
	                'additional_commission_percentage' => $percentage[$i] ?? 0,
	                'created_at' => $this->datetime,
                ]);
            }
        }
        
        return redirect()->to('/update_agent/'.$agent_id)->with('status', 'Agent updated Successfully'); 
	}
	
	public function delete_agent_product($agent_id = 0, $agent_product_id = 0) {
	    $this->agentProductModel->where("agent_product_id", $agent_product_id)->delete();
	    
	    return redirect()->to('/update_agent/'.$agent_id)->with('status', 'Agent updated Successfully'); 
	}

	public function delete_agent($id = null)
	{
		$this->agentModel->delete($id);
		$this->agentProductModel->where('agent_id', $id)->delete();

		return redirect('agent')->with('status', 'Agent deleted Successfully');
	}
	
	public function commission_withdrawal() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Agent Commission Withdrawal Requests']),
			'page_title' => view('partials/page-title', ['title' => 'Agent Commission Withdrawal Requests', 'li_1' => 'Dashboard', 'li_2' => 'Agent List', 'li_3' => 'Agent Commission Withdrawal Requests']),
			'commissions_data' => $this->commissionModel->join('bs_agents', 'bs_agents.agent_id = bs_commissions.agent_id')->orderBy('bs_commissions.commission_id', 'DESC')->findAll(),
		];

		return view('agents/commission_withdrawal', $data);
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
                echo json_encode(["status" => "success", "message" => "Status changed successfully, but unable to refund the amount to agent because it has been done before."]);
            } else {
                if ($status == 2) {
                    $amount = $result[0]['amount'];
        	        $agent_id = $result[0]['agent_id'];
                    
                    $this->db->query("UPDATE bs_agents SET commission = commission + $amount WHERE agent_id = '$agent_id'");
                    $this->db->query("UPDATE bs_commissions SET is_refunded = 1 WHERE commission_id = '$commission_id'");
                    
                    echo json_encode(["status" => "success", "message" => "Status changed successfully, and refunded the amount to agent."]);
                } else {
                    echo json_encode(["status" => "success", "message" => "Status changed successfully."]);
                }
            }
        } else {
            echo json_encode(["error" => "success", "message" => "Failed to change status."]);
        }
	}
	
	public function delete_commission_withdrawal($id = null)
	{
	    $result = $this->commissionModel->where('commission_id', $id)->findAll();
	    
	    if ($result[0]['status'] == 2) {
	        return redirect('commission_withdrawal_agent')->with('status', 'Invalid request, this commission withdrawal request has been cancelled before.');
	    } else {
	        $amount = $result[0]['amount'];
	        $agent_id = $result[0]['agent_id'];
	        
	        $delete = $this->commissionModel->delete($id);
	        $this->db->query("UPDATE bs_commissions SET is_refunded = 1 WHERE commission_id = '$id'");
	        
	        if ($delete) {
	            $this->db->query("UPDATE bs_agents SET commission = commission + $amount WHERE agent_id = '$agent_id'");
	            return redirect('commission_withdrawal_agent')->with('status', 'Commission withdrawal request deleted Successfully');
	        } else {
	            return redirect('commission_withdrawal_agent')->with('status', 'Failed to delete the commission withdrawal request, refund has not been made to the agent.');
	        }
	    }
	}
	
	///////////////////////////////////// Not used
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
