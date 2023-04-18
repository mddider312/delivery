<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Order_Transaction_Product;
use App\Models\Transaction;
use App\Models\Transaction_Product;

class DeliveryController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->transactionModel = new Transaction();
        $this->productModel = new Product();
        $this->partnerModel = new Partner();
        $this->transactionProductModel = new Transaction_Product();
        $this->orderModel = new Order();
        $this->orderProductModel = new Order_Product();
        $this->orderTransactionProductModel = new Order_Transaction_Product();
    }
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Delivery Order List']),
			'page_title' => view('partials/page-title', ['title' => 'Delivery Order List', 'li_1' => 'Dashboard', 'li_2' => 'Delivery Order List']),
			'orders_data' => $this->orderModel->select('*, bs_orders.created_at as order_date')->join('bs_partners', 'bs_partners.id = bs_orders.partner_id')->orderBy('bs_orders.order_id', 'DESC')->findAll(),
		];
		
		return view('drivers/delivery_order', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Order']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Order', 'li_1' => 'Dashboard', 'li_2' => 'Order List', 'li_3' => 'Add New Order']),
			'partners'	 => $this->partnerModel->orderBy('name', 'ASC')->findAll(),
			'products'	 => $this->productModel->orderBy('name', 'ASC')->findAll(),
		];

		return view('orders/add-form', $data);
	}

	public function save_add()
	{
		$data = [
			'partner_id' 	    => $this->request->getVar('partner_id') ?? 0,
			'customer_name'     => $this->request->getVar('customer_name'),
			'customer_phone'    => $this->request->getVar('customer_phone'),
			'customer_address'    => $this->request->getVar('customer_address') ?? "",
			'grand_total'	    => $this->request->getVar('grand_total') ?? 0.00,
			'status'		    => 0,
			'created_at'        => date('Y-m-d H:i:s')
		];

		$result = $this->orderModel->save($data);
		$order_id = $this->orderModel->insertID();
		
		$product_id = $this->request->getVar('product_id');
		$count = COUNT($product_id);
		if ($count != 0) {
		    $price      = $this->request->getVar('price');
		    $qty        = $this->request->getVar('qty');
		    $amount     = $this->request->getVar('amount');
		    
		    for ($i = 0; $i < $count; $i++) {
		        if ($product_id != "") {
		            $data = [
            			'order_id'      => $order_id,
            			'product_id'    => $product_id[$i],
            			'price'	        => $price[$i],
            			'quantity'      => $qty[$i],
            			'subtotal'      => $amount[$i],
            			'created_at'    => date('Y-m-d H:i:s')
            		];
            		$this->orderProductModel->save($data);
            		
            		$order_product_id = $this->orderProductModel->insertID();
            		$quantity = $qty[$i];

            		$data2 = [
        		        'order_id'          => $order_id,
        		        'product_id'        => $product_id[$i],
            			'order_product_id'  => $order_product_id,
            			'created_at'        => date('Y-m-d H:i:s')
        		    ];
            		for ($j = 0; $j < $quantity; $j++) {
            		    $this->orderTransactionProductModel->save($data2);
            		}
		        }
		    }     
		}
		
		if ($result) {
		    return redirect('order')->with('status', 'Order inserted Successfully');
		} else {
		    return redirect('order_add')->with('status', 'Failed to insert the order');
		}
	}
	
	public function order_product_list($id = null) {
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Order Product List']),
			'page_title' => view('partials/page-title', ['title' => 'Order Product List', 'li_1' => 'Dashboard', 'li_2' => 'Order List', 'li_3' => 'Order Product List']),
			'order_data' => $this->orderModel->select('*')->join('bs_partners', 'bs_partners.id = bs_orders.partner_id')->where('order_id', $id)->findAll(),
			'order_product_data' => $this->orderProductModel->select('*')->join('bs_products', 'bs_products.id = bs_orders_products.product_id')->where('bs_orders_products.order_id', $id)->findAll(),
		];

		return view('orders/order-products', $data);
	}
	
	public function delete_order($order_id = null)
	{
		$delete = $this->orderModel->delete($order_id);

        if ($delete) {
            $this->orderProductModel->where('order_id', $order_id)->delete();
            $this->orderTransactionProductModel->where('order_id', $order_id)->delete();
            
            return redirect('order')->with('status', 'Order deleted Successfully');
        } else {
            return redirect('order')->with('status', 'Failed to delete order');
        }
	}
	
    /////// Untouched
	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Transaction']),
			'page_title' => view('partials/page-title', ['title' => 'Update Transaction', 'li_1' => 'Dashboard', 'li_2' => 'Transaction List', 'li_3' => 'Update Transaction']),
			'transaction' => $this->transactionModel->find($id),
			'partners'	 => $this->partnerModel->orderBy('name', 'ASC')->findAll(),
			'products'	 => $this->productModel->orderBy('name', 'ASC')->findAll(),
		];

		return view('transactions/edit-form', $data);
	}

	public function save_update($id = null)
	{
	    $quantity_old = $this->request->getPost('quantity_old');
	    $quantity_new = $this->request->getPost('quantity');
	    
		$add_stocks = ['restock'];

		$data = [
			'type' 			=> $this->request->getPost('type'),
			'partner_id' 	=> $this->request->getPost('partner_id') ?? null,
			'product_id'	=> $this->request->getPost('product_id') ?? null,
			'quantity'		=> $this->request->getPost('quantity')//in_array($this->request->getPost('type'),$add_stocks) ? $this->request->getPost('quantity') : -1 * $this->request->getPost('quantity'), 
		];
		
		$this->transactionModel->where('id', $id)->set($data)->update();

	    $this->transactionProductModel->where('transaction_id', $id)->set([
	        'partner_id' 	    => $this->request->getPost('partner_id') ?? null,
			'product_id'	    => $this->request->getPost('product_id') ?? null,
	    ])->update();
	    
	    // Check if quantity updated.
	    if ($quantity_new > $quantity_old) {
	        $diff = $quantity_new - $quantity_old;
	        $data = [
    			'transaction_id'    => $id,
    			'partner_id' 	    => $this->request->getPost('partner_id') ?? null,
    			'product_id'	    => $this->request->getPost('product_id') ?? null,
    		];
    		
    		for ($i = 0; $i < $diff; $i++) {
    		    $this->transactionProductModel->save($data);
    		}
	    } else if ($quantity_new < $quantity_old) {
	        $diff = $quantity_old - $quantity_new;

	        $trans_prods = $this->db->query("SELECT * FROM bs_transactions_products WHERE transaction_id = '$id' AND is_deleted = 0 ORDER BY id DESC LIMIT $diff")->getResultArray();
	        
	        foreach ($trans_prods as $tp) {
	            $delete = $this->transactionProductModel->delete($tp['id']);

                if ($delete) {
                    $this->transactionProductModel->update($tp['id'], [
            		    'is_deleted' => '1'
            		]);
                }
	        }
	    }

		//return redirect('transaction')->with('status', 'Transaction updated Successfully');
		return redirect()->to('/update_transaction/'.$id)->with('status', 'Transaction updated Successfully');
	}

	public function delete_transaction($id = null)
	{
		$this->transactionModel->delete($id);
		$this->db->query("UPDATE bs_transactions_products SET is_deleted = '1' WHERE transaction_id = '$id'");
        //$this->transactionProductModel->where('transaction_id', $id)->delete();

		return redirect('transaction')->with('status', 'Transaction deleted Successfully');
	}
	
	
	
	public function delete_transaction_product($transaction_id = null, $id = null)
	{
		$delete = $this->transactionProductModel->delete($id);

        if ($delete) {
            $this->transactionProductModel->update($id, [
    		    'is_deleted' => '1'
    		]);
            
            $this->db->query("UPDATE bs_transactions SET quantity = quantity-1 WHERE id = '$transaction_id'");
            
            return redirect()->to('/update_transaction/'.$transaction_id)->with('status', 'Transaction Product deleted Successfully');
        } else {
            return redirect()->to('/update_transaction/'.$transaction_id)->with('status', 'Failed to delete transaction product');
        }
	}
}