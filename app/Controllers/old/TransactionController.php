<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\Transaction_Product;

class TransactionController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->partnerModel = new Partner();
        $this->productModel = new Product();
        $this->staffModel = new Staff();
        $this->transactionModel = new Transaction();
        $this->transactionProductModel = new Transaction_Product();
    }
    
	public function index()
	{
        $transactions = $this->transactionModel->select('*, bs_transactions.id as transaction_id, bs_transactions.created_at as transaction_date, bs_transactions.staff_id as driver_id')->join('bs_partners', 'bs_partners.id = bs_transactions.partner_id')->orderBy('bs_transactions.id', 'DESC')->findAll();
		$transactions_data = [];
		
		foreach ($transactions as $row) 
		{
			$data = 
			[
				'product'	=> (!empty($row['product_id']))?$this->productModel->find($row['product_id']):null,
				'partner'	=> (!empty($row['partner_id'] ))?$this->partnerModel->find($row['partner_id']):null,
				'driver'    => $this->staffModel->where('role = 2')->findAll(),
			];

			$transactions_data[] = array_merge($row, $data);
		}

		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Transaction List']),
			'page_title' => view('partials/page-title', ['title' => 'Transaction List', 'li_1' => 'Dashboard', 'li_2' => 'Transaction List']),
			'transactions_data' => $transactions_data
		];
		return view('transactions/index', $data);
	}

	public function add_form()
	{
	    $products = $this->productModel->orderBy('name', 'ASC')->findAll();
	    
	    for ($i = 0; $i < COUNT($products); $i++) {
	        $product_id = $products[$i]['id'];
	        $result = $this->db->query("SELECT * FROM bs_transactions_products WHERE product_id = '$product_id' AND partner_id = 0 AND order_id = 0 AND transaction_id = 0")->getResultArray();
	        
	        $products[$i]['quantity'] = COUNT($result);
	    }
	    
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Transaction']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Transaction', 'li_1' => 'Dashboard', 'li_2' => 'Transaction List', 'li_3' => 'Add New Transaction']),
			'partners'	 => $this->partnerModel->orderBy('name', 'ASC')->findAll(),
			'products'	 => $products,
			'drivers'    => $this->staffModel->where('role = 2')->orderBy('name', 'ASC')->findAll(),
		];

		return view('transactions/add-form', $data);
	}

	public function save_add()
	{
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        $partner_id = $this->request->getPost('partner_id') ?? 0;
        $staff_id = $this->request->getPost('staff_id') ?? 0;
        
        for ($i = 0; $i < COUNT($product_id); $i++) {
            $data = [
    			'type' 			=> "restock",
    			'partner_id' 	=> $partner_id,
    			'staff_id'      => $staff_id,
    			'product_id'	=> $product_id[$i] ?? null,
    			'quantity'		=> $quantity[$i] ?? 1
    		];
    		
    		$this->transactionModel->save($data);
    		$transaction_id = $this->transactionModel->insertID();
    		
    		
    		
    		for ($j = 0; $j < $quantity[$i]; $j++) {
    		    $result = $this->transactionProductModel->where("order_id = 0 AND partner_id = 0 AND transaction_id = 0 AND product_id = $product_id[$i]")->findAll();
    		    $transaction_product_id = $result[0]['id'] ?? 0;
                
                if ($transaction_product_id != 0) {
        		    $this->transactionProductModel->update($transaction_product_id, [
                        "partner_id" => $partner_id,
                        "transaction_id" => $transaction_id,
                    ]);
                }
    		}
        }

		return redirect('transaction')->with('status', 'Transaction inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Transaction']),
			'page_title' => view('partials/page-title', ['title' => 'Update Transaction', 'li_1' => 'Dashboard', 'li_2' => 'Transaction List', 'li_3' => 'Update Transaction']),
			'transaction' => $this->transactionModel->find($id),
			'partners'	 => $this->partnerModel->orderBy('name', 'ASC')->findAll(),
			'products'	 => $this->productModel->orderBy('name', 'ASC')->findAll(),
			'drivers'    => $this->staffModel->where('role = 2')->orderBy('name', 'ASC')->findAll(),
		];

		return view('transactions/edit-form', $data);
	}

	public function save_update($id = null)
	{
	    $quantity_old = $this->request->getPost('quantity_old');
	    $quantity_new = $this->request->getPost('quantity');
	    $partner_id = $this->request->getPost('partner_id') ?? 0;
	    $staff_id = $this->request->getPost('staff_id') ?? 0;
	    $product_id = $this->request->getPost('product_id') ?? 0;

		$data = [
			'type' 			=> "restock",
			'partner_id' 	=> $partner_id,
			'staff_id'      => $staff_id,
			'product_id'	=> $product_id,
			'quantity'		=> $quantity_new, 
		];
		
		$this->transactionModel->where('id', $id)->set($data)->update();

	    $this->transactionProductModel->where('transaction_id', $id)->set([
	        'partner_id' 	    => $partner_id,
			'product_id'	    => $product_id,
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
    		    $result = $this->transactionProductModel->where("order_id = 0 AND partner_id = 0 AND transaction_id = 0 AND product_id = $product_id")->findAll();
    		    $transaction_product_id = $result[0]['id'] ?? 0;
                
                if ($transaction_product_id != 0) {
                    $this->transactionProductModel->update($transaction_product_id, [
                        "partner_id" => $partner_id,
                        "transaction_id" => $id,
                    ]);
                }
    		}
	    } else if ($quantity_new < $quantity_old) {
	        $diff = $quantity_old - $quantity_new;
	        
	        $db = db_connect();
	        $trans_prods = $db->query("SELECT * FROM bs_transactions_products WHERE transaction_id = '$id' AND status != 1 ORDER BY id DESC LIMIT $diff")->getResultArray();
	        
	        foreach ($trans_prods as $tp) {
                $this->transactionProductModel->update($tp['id'], [
                    "partner_id" => 0,
                    "transaction_id" => 0,
                    "status" => 0,
                    "transaction_status" => 0,
                ]);
	        }
	    }

		//return redirect('transaction')->with('status', 'Transaction updated Successfully');
		return redirect()->to('/update_transaction/'.$id)->with('status', 'Transaction updated Successfully');
	}

	public function delete_transaction($id = null)
	{
		$this->transactionModel->delete($id);
		$this->transactionProductModel->set([
		    "partner_id" => 0,
            "transaction_id" => 0,
            "status" => 0,
            "transaction_status" => 0,
            "order_id" => 0,
            "order_product_id" => 0,
		])->where('transaction_id', $id)->update();

		return redirect('transaction')->with('status', 'Transaction deleted Successfully');
	}
	
	public function transaction_product_list($id = null) {
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Transaction Product List']),
			'page_title' => view('partials/page-title', ['title' => 'Transaction Product List', 'li_1' => 'Dashboard', 'li_2' => 'Transaction List', 'li_3' => 'Transaction Product List']),
			'transactions_data' => $this->transactionModel->select('*, bs_transactions.id as transaction_id, bs_products.name as product_name, bs_partners.name as partner_name, bs_transactions.staff_id as driver_id')->join('bs_partners', 'bs_partners.id = bs_transactions.partner_id')->join('bs_products', 'bs_products.id = bs_transactions.product_id')->where('bs_transactions.id', $id)->findAll(),
			'partners'	 => $this->partnerModel->findAll(),
			'products'	 => $this->productModel->findAll(),
		];

		return view('transactions/transaction-products', $data);
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