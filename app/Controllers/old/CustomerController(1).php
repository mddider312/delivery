<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Product_Brand;
use App\Models\Product_Category;
use App\Models\Product_Size;
use App\Models\Partner;
use App\Models\Partner_Product;
use App\Models\Agent;
use App\Models\Agent_Product;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Order_Payment;
use App\Models\Order_Trade_In_Detail;
use App\Models\Order_Transaction_Product;
use App\Models\Transaction;
use App\Models\Transaction_Product;
use App\Models\Voucher;
use App\Models\Workshop;
use App\Models\Trade_In;
use App\Models\Trade_In_Item;
use App\Models\Trade_In_Type;

//Billplz
require_once APPPATH.'/lib/API.php';
require_once APPPATH.'/lib/Connect.php';
use Billplz\Minisite\API;
use Billplz\Minisite\Connect;

class CustomerController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        $this->session = session();
        
        $this->customerModel = new Customer();
        $this->productModel = new Product();
        $this->productBrandModel = new Product_Brand();
        $this->productCategoryModel = new Product_Category();
        $this->productSizeModel = new Product_Size();
        $this->partnerModel = new Partner();
        $this->partnerProductModel = new Partner_Product();
        $this->agentModel = new Agent();
        $this->agentProductModel = new Agent_Product();
        $this->orderModel = new Order();
        $this->orderPaymentModel = new Order_Payment();
        $this->orderProductModel = new Order_Product();
        $this->orderTradeInDetailModel = new Order_Trade_In_Detail();
        $this->orderTransactionProductModel = new Order_Transaction_Product();
        $this->transactionModel = new Transaction();
        $this->transactionProductModel = new Transaction_Product();
        $this->voucherModel = new Voucher();
        $this->workshopModel = new Workshop();
        $this->tradeInModel = new Trade_In();
        $this->tradeInItemModel = new Trade_In_Item();
        $this->tradeInTypeModel = new Trade_In_Type();
        
        ////////////////////////////////////////////////////////////////////////
        // Billplz
        // Testing API
        $this->api_key = '6c4b86d5-1d59-47ed-bd11-d6327ce2d49d';
        $this->collection_id = 'ggovpepb';
        $this->x_signature = 'S-9kk1EEfmwCQLLme8otR7vQ';
        
        // Live API
        /*
        $this->api_key = 'd77ab6d4-2468-4bae-a65e-13b58b1ab1ea';
        $this->collection_id = 'tkpjakyu';
        $this->x_signature = 'S-gz8kc5hafMmact_cS3mRBw';
        */
        
        $this->websiteurl = "";
        $this->successpath = "";
        $this->fallbackurl = "";
        $this->reference_1_label = '';
        $this->reference_2_label = '';
    }
    
	public function index()
	{
		//
	}

	public function user_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Product List']),
			'page_title' => view('partials/page-title', ['title' => 'Product List', 'li_1' => 'Product', 'li_2' => 'Product List']),			
		];

		return view('customer/index', $data);
	}
	
	public function products_list($partner_id = 0, $workshop_id = 0, $payment_status = '')
	{
	    $agent_email = "";
	    $agent_id = 0;
	    
	    if (!ctype_digit($partner_id)) {
	        $agent_email = $partner_id;
	        $agents = $this->agentModel->where('email', $agent_email)->findAll();
	        
	        if (COUNT($agents) > 0)
	            $agent_id = $agents[0]['agent_id'];
	        
	        $partner_id = 0;
	    }
	    
	    $partners = $this->partnerModel->where('id', $partner_id)->findAll();
	    
	    if ($partner_id == 0 && $agent_id == 0) { // if agent and partner both not found in the system, show blank page
	        return redirect()->to('/shop');
	    }

	    if ($workshop_id != 0) {
	        $workshops = $this->workshopModel->where('workshop_id', $workshop_id)->findAll();
	        
	        if (COUNT($workshops) == 0) {
	            $workshop_id = 0;
	        }
	    }
	    
	    $title = "Shop Product";
	    if ($workshop_id != 0 && $agent_id != 0) {
	        $title .= " (Agent & Workshop)";
	    } else if ($agent_id != 0) {
	        $title .= " (Agent)";
	    } else if ($workshop_id != 0) {
	        $title .= " (Workshop)";
	    }
	    
	    $order_id = 0;
	    $trade_in_id = 0;
	    if (str_contains($payment_status, '-')) {
	        $response_arr = explode("-", $payment_status);
	        
	        $payment_status = $response_arr[0];
	        $order_id = $response_arr[1];
	        $trade_in_id = $response_arr[2];
	    }
	    
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => $title]),
			'page_title' => view('partials/page-title', ['title' => $title, 'li_1' => 'Product', 'li_2' => $title]),
			'trade_in_types' => $this->tradeInTypeModel->orderBy('type', 'DESC')->findAll(),
			'partner_id' => $partner_id,
			'agent_id' => $agent_id,
			'workshop_id' => $workshop_id,
			'partners' => $this->partnerModel->orderBy('name', 'ASC')->findAll(),
			'brands' => $this->productBrandModel->orderBy('brand_name', 'ASC')->findAll(),
			'categories' => $this->productCategoryModel->orderBy('category_name', 'ASC')->findAll(),
			'sizes' => $this->productSizeModel->orderBy('size_name', 'ASC')->findAll(),
			'payment_status' => $payment_status,
			'order_id' => $order_id,
			'trade_in_id' => $trade_in_id,
		];
		
		session()->set(['partner_id' => $partner_id]);
	        
	    return view('customer/products', $data);
	}
	
	public function load_product() {
	    $partner_id     = $this->request->getVar('partner_id');
	    $search         = $this->request->getVar('search');
	    $brand_id       = $this->request->getVar('brand_id');
	    $category_id    = $this->request->getVar('category_id');
	    $size_id        = $this->request->getVar('size_id');
	    
	    $query = [
	        "bs_transactions_products.status" => 0,
	        "bs_transactions_products.transaction_status" => 1,
	        "bs_transactions_products.partner_id" => $partner_id,
	    ];
	    
	    if ($brand_id != "")
	        $query["bs_products.brand_id"] = $brand_id;
	    
	    if ($category_id != "")
	        $query["bs_products.category_id"] = $category_id;
	    
	    if ($size_id != "")
	        $query["bs_products.size_id"] = $size_id;

	    if ($search != "" && $partner_id != 0)
	        $products = $this->transactionProductModel->join('bs_products', 'bs_products.id = bs_transactions_products.product_id')->where($query)->like('bs_products.name', $search)->groupBy('bs_transactions_products.product_id')->findAll();
	    else if ($partner_id != 0)
	        $products = $this->transactionProductModel->join('bs_products', 'bs_products.id = bs_transactions_products.product_id')->where($query)->groupBy('bs_transactions_products.product_id')->findAll();
	    else
	        $products = [];
	    
	    echo json_encode($products);
	}

	public function validate_voucher() {
	    $voucher_code = $this->request->getPost('voucher_code');
	    
	    $voucher = $this->voucherModel->where('code', $voucher_code)->findAll();
	    
	    $result = array(
	        "status" => "failed"
	    );
	    
	    if (COUNT($voucher) > 0) {
	        $result = array(
    	        "status" => "success",
    	        "type" => $voucher[0]['type'],
    	        "discount_amount" => $voucher[0]['discount_amount']
    	    );
	    }
	    
	    echo json_encode($result);
	}
	
	public function billplz($order_id) {
	    $order = $this->orderModel->where('order_id', $order_id)->findAll()[0];
	    
	    $customer_phone = $order['customer_phone'];
	    $customer_name = $order['customer_name'];
	    $customer_address = $order['customer_address'];
	    $final_total = $order['final_total'];
	    $partner_id = $order['partner_id'];
	    $workshop_id = $order['workshop_id'];
	    
	    $this->orderModel->where('order_id', $order_id)->delete();
	    $this->orderProductModel->where('order_id', $order_id)->delete();
	    $this->orderTransactionProductModel->where('order_id', $order_id)->delete();
	    
	    $trade_in = $this->tradeInModel->where('order_id', $order_id)->findAll();
	    $trade_in_id = 0;
	    
	    if (COUNT($trade_in) > 0) {
	        $trade_in_id = $trade_in[0]['trade_in_id'];
	        $this->tradeInModel->where('order_id', $order_id)->delete();
	        $this->tradeInItemModel->where('trade_in_id', $trade_in_id)->delete();
	    }
	    
	    helper('url');
	    $this->websiteurl = base_url("/CustomerController/payment_result/$order_id/$trade_in_id/$partner_id/$workshop_id");
        $this->successpath = base_url("/CustomerController/payment_result/$order_id/$trade_in_id/$partner_id/$workshop_id");
        $this->fallbackurl = base_url("/CustomerController/payment_result/$order_id/$trade_in_id/$partner_id/$workshop_id");
    
        $parameter = array(
            'collection_id' => $this->collection_id,
            'email' => 'noreply@billplz.com',
            'mobile' => $customer_phone,
            'name' => $customer_name,
            'amount' => str_replace(".", "", $final_total),
            'callback_url'=> $this->fallbackurl,
            'description' => 'Payment for Your Order',
        );
        
        $optional = array(
            'redirect_url' => $this->websiteurl,
            // 'reference_1_label' => isset($reference_1_label) ? $reference_1_label : $_REQUEST['reference_1_label'],
            'reference_1' => "Payment for Your Order",
            // 'reference_1_label' => $this->request->getPost('point'),
            // 'reference_2_label' => $this->request->getPost('default_address'),
            // 'reference_2_label' => isset($reference_2_label) ? $reference_2_label : $_REQUEST['reference_2_label'],
            'reference_2' => $customer_address,
            // 'reference_2' => isset($_REQUEST['email']) ? $_REQUEST['email'] : '',
            'deliver' => 'false'
        );
        
        if (empty($parameter['mobile']) && empty($parameter['email'])) {
            $parameter['email'] = 'noreply@billplz.com';
        }
    
        if (!filter_var($parameter['email'], FILTER_VALIDATE_EMAIL)) {
            $parameter['email'] = 'noreply@billplz.com';
        }
        
        $connnect = (new Connect($this->api_key))->detectMode();
        $billplz = new API($connnect);
        list($rheader, $rbody) = $billplz->toArray($billplz->createBill($parameter, $optional));

        // Save to payment table
        $bill_unique_id = $rbody['id'];
        $bill_link      = $rbody['url'];
        $paid           = $rbody['paid'];
        $due_at         = $rbody['due_at'];
        
        $data = [
            "billplz_unique_id" => $bill_unique_id,
            "order_id"          => $order_id,
            "status"            => $paid == "true" ? 1 : 0,
            "billplz_bill_link" => $bill_link,
            "created_at"        => $this->datetime,
        ];
        
        $this->orderPaymentModel->save($data);

        //Handling errors
        if(isset($rbody['error'])){
            echo 'Error type: ' . $rbody['error']['type'];
            print_r($rbody['error']['message']);
            // die();
        }

        /***********************************************/
        // Include tracking code here
        /***********************************************/
        if ($rheader !== 200) {
            echo json_encode(["status" => "failed", "billplz_bill_link" => "", "order_id" => 0, "trade_in_id" => 0]);
            
            if (defined('DEBUG')) {
                echo '<pre>' . print_r($rbody, true) . '</pre>';
            }
            if (!empty($this->fallbackurl)) {
                return redirect()->to($this->fallbackurl);
            }
        } else if ($rheader == 200) {
            echo json_encode(["status" => "success", "billplz_bill_link" => $rbody['url'], "order_id" => $order_id, "trade_in_id" => $trade_in_id]);
        }
        //return redirect()->to($rbody['url']);
	}
	
	public function payment_result($order_id, $trade_in_id, $partner_id, $workshop_id) {
	    $billplz = $_GET['billplz'];
	    
	    $bill_unique_id = $billplz['id'];
	    $paid = $billplz['paid'];
	    $paid_at = $billplz['paid_at'];
	    $x_signature = $billplz['x_signature'];
        
        $order = $this->db->query("SELECT * FROM bs_orders WHERE order_id = '$order_id'")->getResultArray();
        
	    if ($paid == "true") {
	        //add commission and redirect link here
	        
	         $url = "https://graph.facebook.com/v15.0/104857329140724/messages";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer EAAH8DRCQ1pIBALkSyrbTP0AMK7B6sO8cZA6SOIZCZAVwxG377ZB7iwL87aVDJcQxO95ZAOZC7g8xcFj5my7ZBvRB5NEgbSwx5ITj4D7SCVH6lKbioPNryfFiwtYchJ79SxdPM8beh5IVKZCsDfBNaf8kDjzUO1jmQVSLLisFTzKIBvmh9uRZAifEOd1KVSSvBPxmmL0r5xpZCOafrZC7SZB4LrJa', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $customer_name = $order[0]['customer_name'];
        $detail = $this->orderTradeInDetailModel->where(["order_id" => $order_id, "trade_in_id" => $trade_in_id])->findAll();
        $unique_code = base_url("$detail[0]['unique_code']");

        $data = array(
            'messaging_product' => "whatsapp",
            'to' => 60185725842,
            'type' => "template",
            'template' => array("name"=> "order_detail",'language'=>array("code"=>"en_Us"),'components'=> 
               array(
                    array(
                        "type" => "body",
                        "parameters" => array(array("type"=> "text", "text"=> "$customer_name"), array("type"=> "text","text"=> "$unique_code"))
                    )
                )
            )
        );
        
        $fields_string = json_encode($data);
        //echo $fields_string;
        //echo $fields_string;
        echo "<br/>";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        
        //echo $resp;
	        
	        $this->db->query("UPDATE bs_orders SET deleted_at = null, payment_status = 1 WHERE order_id = '$order_id'");
	        $this->db->query("UPDATE bs_orders_payments SET status = 1, paid_at = '$paid_at', x_signature = '$x_signature' WHERE order_id = '$order_id'");
	        $this->db->query("UPDATE bs_orders_products SET deleted_at = null WHERE order_id = '$order_id'");
	        $this->db->query("UPDATE bs_orders_transactions_products SET deleted_at = null WHERE order_id = '$order_id'");
	        $this->db->query("UPDATE bs_trade_ins SET deleted_at = null WHERE order_id = '$order_id'");
	        $this->db->query("UPDATE bs_trade_ins_items SET deleted_at = null WHERE trade_in_id = '$trade_in_id'");
	        $payment_status = $trade_in_id == 0 ? 1 : 2;
	        
	        $encrypt_order_id = $order_id;//$this->encrypt_data($order_id);
            $encrypt_trade_in_id = $trade_in_id;//$this->encrypt_data($trade_in_id);
	        
	        // Give commission when order success, then redirect them back
	        if ($order[0]['agent_id'] != 0) {
	            $agent_id = $order[0]['agent_id'];
	            $commission = $order[0]['agent_commission'];
	            $this->db->query("UPDATE bs_agents SET commission = commission + $commission WHERE agent_id = '$agent_id'");
	            
	            $agent = $this->agentModel->where('agent_id', $agent_id)->findAll();
	            $agent_email = $agent[0]['email'];

	            return redirect()->to(base_url()."/shop/$agent_email/$workshop_id/$payment_status-$encrypt_order_id-$encrypt_trade_in_id");
	        } else if ($order[0]['partner_id'] != 0) {
	            $commission = $order[0]['partner_commission'];
	            $this->db->query("UPDATE bs_partners SET commission = commission + $commission WHERE id = '$partner_id'");
	            
	            return redirect()->to(base_url()."/shop/$partner_id/$workshop_id/$payment_status-$encrypt_order_id-$encrypt_trade_in_id");
	        } 
	    } else if ($paid == "false") {
	        if ($order[0]['agent_id'] != 0) {
	            $agent_id = $order[0]['agent_id'];
	            $agent = $this->agentModel->where('agent_id', $agent_id)->findAll();
	            $agent_email = $agent[0]['email'];
	            
	            return redirect()->to(base_url()."/shop/$agent_email/$workshop_id/0");
	        } else if ($order[0]['partner_id'] != 0) {
	            return redirect()->to(base_url()."/shop/$partner_id/$workshop_id/0");
	        } 
	    }
	}
	
	public function encrypt_data($data) {
	    $keyword[0]['key'] = "0"; $keyword[0]['value'] = "g";
	    $keyword[1]['key'] = "1"; $keyword[1]['value'] = "a";
	    $keyword[2]['key'] = "2"; $keyword[2]['value'] = "x";
	    $keyword[3]['key'] = "3"; $keyword[3]['value'] = "z";
	    $keyword[4]['key'] = "4"; $keyword[4]['value'] = "t";
	    $keyword[5]['key'] = "5"; $keyword[5]['value'] = "o";
	    $keyword[6]['key'] = "6"; $keyword[6]['value'] = "b";
	    $keyword[7]['key'] = "7"; $keyword[7]['value'] = "f";
	    $keyword[8]['key'] = "8"; $keyword[8]['value'] = "l";
	    $keyword[9]['key'] = "9"; $keyword[9]['value'] = "h";
	    
	    $e_data = "";
	    $data_arr = explode(' ', $data);
	    
	    foreach ($data_arr as $d) {
	        for ($i = 0; $i < COUNT($keyword); $i++) {
    	        if ($d == $keyword[$i]['key']) {
    	            $e_data = $e_data . $keyword[$i]['value'];
    	        }
    	    }
	    }
	    
	    return $e_data;
	}
	
	public function decrypt_data($data) {
	    $keyword_arr = [["key"=>"g", "value"=>"0"], ["key"=>"a", "value"=>"1"], ["key"=>"x", "value"=>"2"], ["key"=>"z", "value"=>"3"], ["key"=>"t", "value"=>"4"], ["key"=>"o", "value"=>"5"], ["key"=>"b", "value"=>"6"], ["key"=>"f", "value"=>"7"], ["key"=>"l", "value"=>"8"], ["key"=>"h", "value"=>"9"]];
	    $decrypted_data = "";
	    
	    $data_arr = explode(' ', $data);
	    
	    foreach ($data_arr as $d) {
            foreach ($keyword_arr as $k) {
                if ($k['key'] == $d) {
                    $decrypted_data .= $k['value'];
                }
            }
        }
	    
	    return $decrypted_data;
	}
	
	public function place_order() {
        $condition                  = $this->request->getPost('condition'); // 0-invalid, 1-tradein only, 2-order only, 3-tradein and order
        $customer_name              = $this->request->getPost('customer_name');
        $customer_phone             = $this->request->getPost('customer_phone');
        $license_plate              = $this->request->getPost('license_plate');
        $customer_address           = $this->request->getPost('customer_address') ?? "";
	    $workshop_id                = $this->request->getPost('workshop_id') ?? 0;
        $voucher_code               = $this->request->getPost('voucher_code') ?? "";
        $voucher_discount           = $this->request->getPost('voucher_discount')?? 0.00;
        $trade_in_total_discount    = $this->request->getPost('trade_in_total_discount') ?? 0.00;
        $final_total                = $this->request->getPost('final_total') ?? 0.00;
        $trade_in_type_id           = $this->request->getPost('trade_in_type_id') ?? [];
        $trade_in_quantity          = $this->request->getPost('trade_in_quantity') ?? [];
        $trade_in_discount          = $this->request->getPost('trade_in_discount') ?? [];
        $partner_id                 = $this->request->getPost('partner_id') ?? 0;
        $agent_id                   = $this->request->getPost('agent_id') ?? 0;
        $cart                       = $this->request->getPost('cart') ?? [];
        $grand_total                = $this->request->getPost('grand_total') ?? 0.00;
        
        if ($condition == "0") { //  invalid
 
        }
        
        if ($condition == "1") { // tradein only
            $data = [
    			'partner_id' 	    => $partner_id,
    			'agent_id'          => $agent_id,
    			'workshop_id'       => $workshop_id,
    			'customer_name'     => $customer_name,
    			'customer_phone'    => $customer_phone,
    			'license_plate'     => $license_plate,
    			'customer_address'  => $customer_address,
    			'order_id'          => 0,
    			'staff_id'          => 0,
    			'grand_total'       => $trade_in_total_discount,
    			"payable_amount"    => $trade_in_total_discount,
    			'status'		    => 1,
    			'payment_status'    => 0,
    			'created_at'        => $this->datetime,
    		];
    		
    		$result = $this->tradeInModel->save($data);
    		$trade_in_id = $this->tradeInModel->insertID();
    		
    		if ($result) { // Add the trade-in payable amoun to partner's commission,  because partner will pay the amount manually to customer.
    		    $this->db->query("UPDATE bs_partners SET commission = commission + $trade_in_total_discount WHERE id = '$partner_id'");
    		}
    		
    		$count = COUNT($trade_in_type_id);
    		
    		for ($i = 0; $i < $count; $i++) {
    		    $type_id = $trade_in_type_id[$i];
    		    $quantity = $trade_in_quantity[$i];
    		    $discount = $trade_in_discount[$i];
    		    
    		    if ($quantity != 0) {
    		        $data2 = [
        		        'trade_in_id' => $trade_in_id,
        		        'trade_in_type_id' => $type_id,
        		        'quantity' => $quantity,
        		        'sub_total' => $discount,
        		        'created_at' => $this->datetime,
        		    ];
        		    
        		    $this->tradeInItemModel->save($data2);
    		    }
    		}
    		
    		if ($result) {
    		    echo json_encode(["status" => "success", "billplz_bill_link" => "", "order_id" => 0, "trade_in_id" => $trade_in_id]);
    		} else {
    		    echo json_encode(["status" => "failed", "billplz_bill_link" => "", "order_id" => 0, "trade_in_id" => 0]);
    		}
        }
        
        if ($condition == "2") { // order only
            $data = [
    			'partner_id' 	    => $partner_id,
    			'agent_id'          => $agent_id,
    			'workshop_id'       => $workshop_id,
    			'customer_name'     => $customer_name,
    			'customer_phone'    => $customer_phone,
    			'license_plate'     => $license_plate,
    			'customer_address'  => $customer_address,
    			'voucher_code'      => $voucher_code,
    			'voucher_discount'  => $voucher_discount,
    			'trade_in_discount' => $trade_in_total_discount,
    			'grand_total'	    => $grand_total,
    			'final_total'       => $final_total,
    			'status'		    => 0,
    			'payment_status'    => $final_total <= 0.00 ? 0 : 2,
    			'created_at'        => $this->datetime,
    		];
    
    		$result = $this->orderModel->save($data);
    		$order_id = $this->orderModel->insertID();
    		
    		$count = COUNT($cart);
    		
    		if ($count != 0) {
    		    $total_partner_commission = 0.00;
    		    $total_agent_commission = 0.00;
    		    
    		    foreach ($cart as $c) {
    		        if ($c[0] != 0) {
    		            $product_id = $c[0];
        		        $quantity = $c[1];
        		        
        		        $product = $this->productModel->where('id', $product_id)->findAll();
        		        
        		        $price = $workshop_id == 0 
        		            ? $product[0]['selling_price']
        		            : $product[0]['workshop_price'];
        		        $subtotal = $price * $quantity;
        		        
        		        $product_commission_rate = $product[0]['commission'];
        		        if ($agent_id != 0) { // if have agent_id assigned, give the commission to agent
        		            $agentProduct = $this->agentProductModel->where(['agent_id' => $agent_id, 'product_id' => $product_id])->findAll();
            		        $additional_product_commission_rate = COUNT($agentProduct) == 0 ? 0.00 : $agentProduct[0]['additional_commission_percentage'];
        		            $total_product_commission_rate = $product_commission_rate + $additional_product_commission_rate;
            		        $commission = $subtotal * $total_product_commission_rate / 100;
            		        $total_agent_commission += $commission;
        		        } else if ($partner_id != 0) { // if have partner_id assigned and do not have agent_id assigned, give the commission to partner
        		            $partnerProduct = $this->partnerProductModel->where(['partner_id' => $partner_id, 'product_id' => $product_id])->findAll();
            		        $additional_product_commission_rate = COUNT($partnerProduct) == 0 ? 0.00 : $partnerProduct[0]['additional_commission_percentage'];
            		        $total_product_commission_rate = $product_commission_rate + $additional_product_commission_rate;
            		        $commission = $subtotal * $total_product_commission_rate / 100;
            		        $total_partner_commission += $commission;
        		        }
        		        
        		        $data = [
                			'order_id'      => $order_id,
                			'product_id'    => $product_id,
                			'price'	        => $price,
                			'quantity'      => $quantity,
                			'subtotal'      => $subtotal,
                			'created_at'    => $this->datetime,
                		];
                		
                		$this->orderProductModel->save($data);
                		$order_product_id = $this->orderProductModel->insertID();
                        
                        $data2 = [
            		        'order_id'          => $order_id,
            		        'product_id'        => $product_id,
                			'order_product_id'  => $order_product_id,
                			'warranty_month'    => $workshop_id == 0 ? $product[0]['warranty_month'] : $product[0]['workshop_warranty_month'],
                			'created_at'        => $this->datetime,
            		    ];
            		    
            		    for ($j = 0; $j < $quantity; $j++) {
                		    $this->orderTransactionProductModel->save($data2);
                		}
    		        }
    		    }
    		    
    		    if ($agent_id != 0) {
    		        $this->db->query("UPDATE bs_orders SET agent_commission = $total_agent_commission WHERE order_id = '$order_id'");
    		    } else if ($partner_id != 0) {
    		        $this->db->query("UPDATE bs_orders SET partner_commission = $total_partner_commission WHERE order_id = '$order_id'");
    		    }
    		}
    		
    		if ($result) {
    		    if ($final_total <= 0.00) {
    		        echo json_encode(["status" => "success", "billplz_bill_link" => "", "order_id" => $order_id, "trade_in_id" => 0]);
    		    } else {
    		        return redirect()->to("billplz/$order_id");
    		    }
    		} else {
    		    echo json_encode(["status" => "failed", "billplz_bill_link" => "", "order_id" => 0, "trade_in_id" => 0]);
    		}
        }
        
        if ($condition == "3") { // tradein and order
            $data = [
    			'partner_id' 	    => $partner_id,
    			'agent_id'          => $agent_id,
    			'workshop_id'       => $workshop_id,
    			'customer_name'     => $customer_name,
    			'customer_phone'    => $customer_phone,
    			'license_plate'     => $license_plate,
    			'customer_address'  => $customer_address,
    			'voucher_code'      => $voucher_code,
    			'voucher_discount'  => $voucher_discount,
    			'trade_in_discount' => $trade_in_total_discount,
    			'grand_total'	    => $grand_total,
    			'final_total'       => $final_total,
    			'status'		    => 0,
    			'payment_status'    => $final_total <= 0.00 ? 0 : 2,
    			'created_at'        => $this->datetime,
    		];
    
    		$result = $this->orderModel->save($data);
    		$order_id = $this->orderModel->insertID();
    		
    		$count = COUNT($cart);
    		
    		if ($count != 0) {
    		    $total_partner_commission = 0.00;
    		    $total_agent_commission = 0.00;
    		    
    		    foreach ($cart as $c) {
    		        if ($c[0] != 0) {
    		            $product_id = $c[0];
        		        $quantity = $c[1];
        		        
        		        $product = $this->productModel->where('id', $product_id)->findAll();
        		        
        		        $price = $workshop_id == 0 
        		            ? $product[0]['selling_price']
        		            : $product[0]['workshop_price'];
        		        $subtotal = $price * $quantity;
        		        
        		        $product_commission_rate = $product[0]['commission'];
        		        if ($agent_id != 0) { // if have agent_id assigned, give the commission to agent
        		            $agentProduct = $this->agentProductModel->where(['agent_id' => $agent_id, 'product_id' => $product_id])->findAll();
            		        $additional_product_commission_rate = COUNT($agentProduct) == 0 ? 0.00 : $agentProduct[0]['additional_commission_percentage'];
        		            $total_product_commission_rate = $product_commission_rate + $additional_product_commission_rate;
            		        $commission = $subtotal * $total_product_commission_rate / 100;
            		        $total_agent_commission += $commission;
        		        } else if ($partner_id != 0) { // if have partner_id assigned and do not have agent_id assigned, give the commission to partner
        		            $partnerProduct = $this->partnerProductModel->where(['partner_id' => $partner_id, 'product_id' => $product_id])->findAll();
            		        $additional_product_commission_rate = COUNT($partnerProduct) == 0 ? 0.00 : $partnerProduct[0]['additional_commission_percentage'];
            		        $total_product_commission_rate = $product_commission_rate + $additional_product_commission_rate;
            		        $commission = $subtotal * $total_product_commission_rate / 100;
            		        $total_partner_commission += $commission;
        		        }
        		        
        		        $data = [
                			'order_id'      => $order_id,
                			'product_id'    => $product_id,
                			'price'	        => $price,
                			'quantity'      => $quantity,
                			'subtotal'      => $subtotal,
                			'created_at'    => $this->datetime,
                		];
                		
                		$this->orderProductModel->save($data);
                		$order_product_id = $this->orderProductModel->insertID();
                        
                        $data2 = [
            		        'order_id'          => $order_id,
            		        'product_id'        => $product_id,
                			'order_product_id'  => $order_product_id,
                			'warranty_month'    => $workshop_id == 0 ? $product[0]['warranty_month'] : $product[0]['workshop_warranty_month'],
                			'created_at'        => $this->datetime,
            		    ];
            		    
            		    for ($j = 0; $j < $quantity; $j++) {
                		    $this->orderTransactionProductModel->save($data2);
                		}
    		        }
    		    }
    		    
    		    if ($agent_id != 0) {
    		        $this->db->query("UPDATE bs_orders SET agent_commission = $total_agent_commission WHERE order_id = '$order_id'");
    		    } else if ($partner_id != 0) {
    		        $this->db->query("UPDATE bs_orders SET partner_commission = $total_partner_commission WHERE order_id = '$order_id'");
    		    }
    		}
    		
    		$trade_in_status = $final_total >= 0.00 ? 0 : 2;
    		$payable_amount = $final_total >= 0.00 ? 0.00 : explode('-', $final_total)[1];
    		$data3 = [
    			'partner_id' 	    => $partner_id,
    			'agent_id'          => $agent_id,
    			'workshop_id'       => $workshop_id,
    			'customer_name'     => $customer_name,
    			'customer_phone'    => $customer_phone,
    			'license_plate'     => $license_plate,
    			'customer_address'  => $customer_address,
    			'order_id'          => $order_id,
    			'staff_id'          => 0,
    			'grand_total'       => $trade_in_total_discount,
    			'payable_amount'    => $payable_amount,
    			'status'		    => $trade_in_status,
    			'trade_in_status'   => 0,
    			'created_at'        => $this->datetime,
    		];
    		
    		$result = $this->tradeInModel->save($data3);
    		$trade_in_id = $this->tradeInModel->insertID();
    		
    		if ($result) { // Add the trade-in payable amoun to partner's commission,  because partner will pay the amount manually to customer.
    		    $this->db->query("UPDATE bs_partners SET commission = commission + $payable_amount WHERE id = '$partner_id'");
    		}
    		
    		$count = COUNT($trade_in_type_id);
    		
    		for ($i = 0; $i < $count; $i++) {
    		    $type_id = $trade_in_type_id[$i];
    		    $quantity = $trade_in_quantity[$i];
    		    $discount = $trade_in_discount[$i];

    		    if ($quantity != 0) {
    		        $data4 = [
        		        'trade_in_id' => $trade_in_id,
        		        'trade_in_type_id' => $type_id,
        		        'quantity' => $quantity,
        		        'sub_total' => $discount,
        		        'created_at' => $this->datetime,
        		    ];
        		    
        		    $this->tradeInItemModel->save($data4);
    		    }
    		}
    		
    		if ($result) {
    		    if ($final_total <= 0.00) {
    		        echo json_encode(["status" => "success", "billplz_bill_link" => "", "order_id" => $order_id, "trade_in_id" => $trade_in_id]);
    		    } else {
    		        return redirect()->to("billplz/$order_id");
    		    }
    		} else {
    		    echo json_encode(["status" => "failed", "billplz_bill_link" => "", "order_id" => 0, "trade_in_id" => 0]);
    		}
        }
	}
	
	public function load_checkout_detail() {
	    $order_id = $this->request->getVar("order_id");
	    $trade_in_id = $this->request->getVar("trade_in_id");
	    
	    $html = "";
	    $customer_html = "";
	    $order_html = "";
	    $trade_in_html = "";
	    $have_no_order = true;

	    $title = "<p class='h5' style='text-align:center;'>".$this->request->getVar("title")."</p><hr>";
	    
	    if ($order_id != 0) {
	        $have_no_order = false;
	        $order = $this->db->query("SELECT * FROM bs_orders WHERE order_id = '$order_id'")->getResultArray()[0];
	        $order_products = $this->db->query("SELECT * FROM bs_orders_products WHERE order_id = '$order_id'")->getResultArray();
	        //$order = $this->orderModel->where('order_id', $order_id)->findAll()[0];
    	    //$order_products = $this->orderProductModel->where('order_id', $order_id)->findAll();
	        $order_products_html = "";

	        $workshop = $this->workshopModel->where('workshop_id', $order['workshop_id'])->findAll();
	        $workshop_unique_id = $workshop[0]['workshop_unique_id'] ?? 0;
	        $workshop_html = $workshop_unique_id == 0 ? "" : "
	            <tr>
                    <th style='text-align:left;'>Workshop</th>
                    <td style='text-align:center;'>:</td>
                    <td style='text-align:left;'>$workshop_unique_id</td>
                </tr>
	        ";
	        
	        $partner = $this->partnerModel->where('id', $order['partner_id'])->findAll();
	        $partner_name = $partner[0]['name'] ?? "n/a";
	        $partner_html = $order['partner_id'] == 0 ? "" : "
	            <tr>
                    <th style='text-align:left;'>Partner</th>
                    <td style='text-align:center;'>:</td>
                    <td style='text-align:left;'>$partner_name</td>
                </tr>
	        ";
	        
	        $agent = $this->agentModel->where('agent_id', $order['agent_id'])->findAll();
	        $agent_name = $agent[0]['name'] ?? "n/a";
	        $agent_html = $order['agent_id'] == 0 ? "" : "
	            <tr>
                    <th style='text-align:left;'>Agent</th>
                    <td style='text-align:center;'>:</td>
                    <td style='text-align:left;'>$agent_name</td>
                </tr>
	        ";

	        $voucher_html = $order['voucher_code'] == "" ? "" : "
	            <tr>
                    <th style='text-align:left;'>Voucher</th>
                    <td style='text-align:center;'>:</td>
                    <td style='text-align:left;'>$order[voucher_code]</td>
                </tr>
	        ";
	        
	        $voucher_discount_html = $order['voucher_code'] == "" ? "" : "
	            <tr>
                    <td colspan='2' style='text-align:right;'>Voucher Discount (RM)</td>
                    <td style='text-align:right;'>-$order[voucher_discount]</td>
                </tr>
	        ";
	        
	        $trade_in_discount_html = $order['trade_in_discount'] == 0 ? "" : "
	            <tr>
                    <td colspan='2' style='text-align:right;'>Trade-In Discount (RM)</td>
                    <td style='text-align:right;'>-$order[trade_in_discount]</td>
                </tr>
	        ";
	        
	        $customer_html = "
                <p class='h6' style='text-align:left;'>Customer Details:</p>
                <div class='table-responsive'>
                    <table class='table table-bordered table-striped table-sm font-size-14'>
                        <tbody>
                            <tr>
                                <th style='text-align:left;'>Order Date</th>
                                <td style='text-align:center;'>:</td>
                                <td style='text-align:left;'>$order[created_at]</td>
                            </tr>
                            <tr>
                                <th style='text-align:left;'>Name</th>
                                <td style='text-align:center;'>:</td>
                                <td style='text-align:left;'>$order[customer_name]</td>
                            </tr>
                            <tr>
                                <th style='text-align:left;'>Phone No.</th>
                                <td style='text-align:center;'>:</td>
                                <td style='text-align:left;'>$order[customer_phone]</td>
                            </tr>
                            <tr>
                                <th style='text-align:left;'>No. Plate</th>
                                <td style='text-align:center;'>:</td>
                                <td style='text-align:left;'>$order[license_plate]</td>
                            </tr>
                            <tr>
                                <th style='text-align:left;'>Address</th>
                                <td style='text-align:center;'>:</td>
                                <td style='text-align:left;'>$order[customer_address]</td>
                            </tr>
                            $partner_html
                            $agent_html
                            $workshop_html
                            $voucher_html
                        </tbody>
                    </table>
                </div>
            ";
            
            foreach ($order_products as $product) {
                $product_detail = $this->productModel->where('id', $product['product_id'])->findAll();
                $name = COUNT($product_detail) == 0 ? '-' : $product_detail[0]['name'];
                
                $order_products_html .= "
                    <tr>
                        <td style='text-align:left;'>$name</td>
                        <td style='text-align:center;'>$product[quantity]</td>
                        <td style='text-align:right;'>$product[subtotal]</td>
                    </tr>
                ";
            }
            
            $order_html = "
                <p class='h6' style='text-align:left;'>Order Details:</p>
                <div class='table-responsive'>
                    <table class='table table-bordered table-striped table-sm font-size-14'>
                        <thead>
                            <tr>
                                <th class='text-center' style='width:50%;'>Name</th>
                                <th class='text-center' style='width:20%;'>Qty</th>
                                <th class='text-center' style='width:30%;'>Subtotal<br>(RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            $order_products_html
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='2' style='text-align:right;'>Grand Total (RM)</td>
                                <td style='text-align:right;'>$order[grand_total]</td>
                            </tr>
                            $voucher_discount_html
                            $trade_in_discount_html
                            <tr>
                                <td colspan='2' style='text-align:right;'>Final Total (RM)</td>
                                <td style='text-align:right;'>$order[final_total]</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            ";
	    }
	    
	    if ($trade_in_id != 0) {
	        $trade_in = $this->tradeInModel->where('trade_in_id', $trade_in_id)->findAll()[0];
    	    $trade_in_items = $this->tradeInItemModel->where('trade_in_id', $trade_in_id)->findAll();
            $trade_in_items_html = "";
            
            if ($have_no_order) {
                $customer_html = "
                    <p class='h6' style='text-align:left;'>Customer Details:</p>
                    <div class='table-responsive'>
                        <table class='table table-bordered table-striped table-sm font-size-14'>
                            <tbody>
                                <tr>
                                    <th style='text-align:left;'>Order Date</th>
                                    <td style='text-align:center;'>:</td>
                                    <td style='text-align:left;'>$trade_in[created_at]</td>
                                </tr>
                                <tr>
                                    <th style='text-align:left;'>Name</th>
                                    <td style='text-align:center;'>:</td>
                                    <td style='text-align:left;'>$trade_in[customer_name]</td>
                                </tr>
                                <tr>
                                    <th style='text-align:left;'>Phone No.</th>
                                    <td style='text-align:center;'>:</td>
                                    <td style='text-align:left;'>$trade_in[customer_phone]</td>
                                </tr>
                                <tr>
                                    <th style='text-align:left;'>No. Plate</th>
                                    <td style='text-align:center;'>:</td>
                                    <td style='text-align:left;'>$trade_in[license_plate]</td>
                                </tr>
                                <tr>
                                    <th style='text-align:left;'>Address</th>
                                    <td style='text-align:center;'>:</td>
                                    <td style='text-align:left;'>$trade_in[customer_address]</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                ";
            }

            foreach ($trade_in_items as $item) {
                $trade_in_types = $this->tradeInTypeModel->where('trade_in_type_id', $item['trade_in_type_id'])->findAll();
                $type = COUNT($trade_in_types) == 0 ? '-' : $trade_in_types[0]['type'];
                
                $trade_in_items_html .= "
                    <tr>
                        <td style='text-align:left;'>$type</td>
                        <td style='text-align:center;'>$item[quantity]</td>
                        <td style='text-align:right;'>$item[sub_total]</td>
                    </tr>
                ";
            }
            
            $trade_in_html = "
                <p class='h6' style='text-align:left;'>Trade-In Details:</p>
                <div class='table-responsive'>
                    <table class='table table-bordered table-striped table-sm font-size-14'>
                        <thead>
                            <tr>
                                <th class='text-center' style='width:50%;'>Type</th>
                                <th class='text-center' style='width:20%;'>Qty</th>
                                <th class='text-center' style='width:30%;'>Subtotal<br>(RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            $trade_in_items_html
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='2' style='text-align:right;'>Total (RM)</td>
                                <td style='text-align:right;'>$trade_in[grand_total]</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            ";
	    }
    	
    	$html = $title . "<div class='h6' style='text-align:left;'>" . $customer_html . $order_html . $trade_in_html . "</div>";
        
        $unique_code = date("Ymd_His")."_".$this->generateRandomString();
        $this->orderTradeInDetailModel->insert([
            "order_id" => $order['order_id'] ?? 0,
            "trade_in_id" => $trade_in['trade_in_id'] ?? 0,
            "unique_code" => $unique_code,
            "html" => $html,
            "created_at" => $this->datetime,
        ]);
        
        echo $html;
	}
	
	public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
	
	public function sendWhatsApp() {
	    $customer_name = "Lim Mei Mei";
	    
        $url = "https://graph.facebook.com/v15.0/104857329140724/messages";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer EAAH8DRCQ1pIBALIT3kaiYjlLZBKnX1xW3Rh1V47QQHRHSfSkTNvVrAUWp1LWKBArTgOzEvvmZC4pso7VocxIEnEwsHmbMujg269v17E35zBhGiUNQI0GvLS7jwetHbzM3hOTZAWoIzkgeEZCJWJmo4kcFhbYMqDZAKlgEsO8SPJKDnHGnZBHdCm4vumPkT7I72hOiGXpSiE7dFp7yOKLsZC', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = array(
            'messaging_product' => "whatsapp",
            'to' => 60185725842,
            'type' => "template",
            'template' => array("name"=> "Hello $customer_name, thank you for purchase with Bateri Laju. Here are your order details",'language'=>array("code"=>"en_Us"),'components'=> 
               array(
                    array(
                        "type" => "body",
                        //"parameters" => array(array("type"=> "text","text"=> "google.com"),array("type"=> "text","text"=> "Mr Jibran"),array("type"=> "text","text"=> "order success"))
                    )
                )
            )
        );
        
        $fields_string = json_encode($data);
        //echo $fields_string;
        //echo $fields_string;
        echo "<br/>";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        
        echo $resp;
 
	}
}
