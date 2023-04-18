<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use App\Models\Product_Brand;
use App\Models\Product_Category;
use App\Models\Product_Size;
use App\Models\Transaction;
use App\Models\Transaction_Product;

class ProductController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();

        $this->productModel = new Product();
        $this->productBrandModel = new Product_Brand();
        $this->productCategoryModel = new Product_Category();
        $this->productSizeModel = new Product_Size();
        $this->transactionModel = new Transaction();
        $this->transactionProductModel = new Transaction_Product();
    }
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Product List']),
			'page_title' => view('partials/page-title', ['title' => 'Product List', 'li_1' => 'Dashboard', 'li_2' => 'Product List']),
			'products_data' => $this->productModel->orderBy('id', 'DESC')->findAll(),
			'brands' => $this->productBrandModel->findAll(),
			'categories' => $this->productCategoryModel->findAll(),
			'sizes' => $this->productSizeModel->findAll(),
		];
		return view('products/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Product']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Product', 'li_1' => 'Dashboard', 'li_2' => 'Product List', 'li_3' => 'Add New Product']),
			'brands' => $this->productBrandModel->orderBy('brand_name', 'ASC')->findAll(),
			'categories' => $this->productCategoryModel->orderBy('category_name', 'ASC')->findAll(),
			'sizes' => $this->productSizeModel->orderBy('size_name', 'ASC')->findAll(),
		];

		return view('products/add-form', $data);
	}

	public function save_add()
	{
		$file = $this->request->getFile('product_photo');
		$file->move(ROOTPATH.'public/uploads/products');

		$data = [
			'photo'	=> $file->getName() ? 'uploads/products/'.$file->getName():'',
			'name' => $this->request->getPost('name'),
			'description' => $this->request->getPost('description'),
			'category_id' => $this->request->getPost('category_id') ?? 0,
    		'brand_id' => $this->request->getPost('brand_id') ?? 0,
    		'size_id' => $this->request->getPost('size_id') ?? 0,
			'cost' => $this->request->getPost('cost'),
			'selling_price' => $this->request->getPost('selling_price'),
			'warranty_month' => $this->request->getPost('warranty_month'),
			'workshop_price' => $this->request->getPost('workshop_price'),
			'workshop_warranty_month' => $this->request->getPost('workshop_warranty_month'),
			'commission' => $this->request->getPost('commission'),
		];
        
        $result = $this->productModel->save($data);
        
        $product_id = $this->productModel->insertID();
        $quantity = $this->request->getPost('quantity');
        
        $data = [
			'transaction_id'    => 0,
			'partner_id' 	    => 0,
			'product_id'	    => $product_id,
		];
        
        if ($result) {
            for ($i=0; $i<$quantity; $i++)
    		    $this->transactionProductModel->save($data);
        }
            
		return redirect('product')->with('status', 'Product inserted Successfully');
	}
	
	public function add_product_quantity() {
	    $product_id = $this->request->getPost('product_id');
	    $quantity = $this->request->getPost('quantity');
	    
	    $data = [
			'transaction_id'    => 0,
			'partner_id' 	    => 0,
			'product_id'	    => $product_id,
		];

        for ($i=0; $i<$quantity; $i++)
		    $result = $this->transactionProductModel->save($data);
            
        if ($result) {
            echo "success";
        } else {
            echo "failed";
        }
	}

	public function update_form($id = null)
	{
	    $result = $this->db->query("SELECT * FROM bs_transactions_products WHERE product_id = '$id' AND partner_id = 0 AND order_id = 0")->getResultArray();
        $quantity = COUNT($result);
	    
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Product']),
			'page_title' => view('partials/page-title', ['title' => 'Update Product', 'li_1' => 'Dashboard', 'li_2' => 'Product List', 'li_3' => 'Update Product']),
			'product' => $this->productModel->find($id),
			'transaction_products' => $this->transactionProductModel->where("product_id = $id")->findAll(),
			'quantity' => $quantity,
			'brands' => $this->productBrandModel->orderBy('brand_name', 'ASC')->findAll(),
			'categories' => $this->productCategoryModel->orderBy('category_name', 'ASC')->findAll(),
			'sizes' => $this->productSizeModel->orderBy('size_name', 'ASC')->findAll(),
		];

		return view('products/edit-form', $data);
	}

	public function save_update($id = null)
	{
	    if ($file = $this->request->getFile('product_photo')) {
            if ($file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/products', $newName);
            }
        }
        
        $data = [
    		'name' => $this->request->getPost('name'),
    		'description' => $this->request->getPost('description'),
    		'category_id' => $this->request->getPost('category_id') ?? 0,
    		'brand_id' => $this->request->getPost('brand_id') ?? 0,
    		'size_id' => $this->request->getPost('size_id') ?? 0,
    		'cost' => $this->request->getPost('cost'),
    		'selling_price' => $this->request->getPost('selling_price'),
    		'warranty_month' => $this->request->getPost('warranty_month'),
    		'workshop_price' => $this->request->getPost('workshop_price'),
    		'workshop_warranty_month' => $this->request->getPost('workshop_warranty_month'),
    		'commission' => $this->request->getPost('commission'),
    	];
    	
    	if (isset($newName)) {
            $data['photo']= 'uploads/products/'.$newName;
        }
	    
		$this->productModel->update($id, $data);
		
		return redirect('product')->with('status', 'Product updated Successfully');
	}

	public function delete_product($id = null)
	{
		$this->productModel->delete($id);

		return redirect('product')->with('status', 'Product deleted Successfully');
	}
	
	public function view_product($id = null) {
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Product Details']),
			'page_title' => view('partials/page-title', ['title' => 'Product Details', 'li_1' => 'Dashboard', 'li_2' => 'Product List', 'li_3' => 'Product Details']),
			'product' => $this->productModel->find($id),
			'transaction_products' => $this->transactionProductModel->where("product_id = $id")->findAll(),
			'brands' => $this->productBrandModel->findAll(),
			'categories' => $this->productCategoryModel->findAll(),
			'sizes' => $this->productSizeModel->findAll(),
		];

		return view('products/product-details', $data);
	}
	
	public function delete_transaction_product($product_id = null, $transaction_product_id) {
	    $result = $this->transactionProductModel->where("id", $transaction_product_id)->delete();
	    
	    if ($result) {

	        return redirect()->back()->with('status', 'Successfully deleted this product qr');
	    } else {
	        return redirect()->back()->with('status', 'Failed to delete this product qr');
	    }
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function product_brand() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Set Product Brand']),
			'page_title' => view('partials/page-title', ['title' => 'Set Product Brand', 'li_1' => 'Dashboard', 'li_2' => 'Set Product Brand']),
			'brands' => $this->productBrandModel->findAll(),
		];
		
		return view('products/product-brands', $data);
	}
	
	public function update_product_brand() {
	    $product_brand_id = $this->request->getPost('product_brand_id');
	    $brand_name = $this->request->getPost('brand_name');
	    
	    for ($i = 0; $i < COUNT($brand_name); $i++) {
	        if (array_key_exists($i, $product_brand_id)) {
	            $data = [
	                'brand_name' => $brand_name[$i],
	            ];
	            
	            $this->productBrandModel->update($product_brand_id[$i], $data);
	        } else {
	            $data = [
	                'brand_name' => $brand_name[$i],
	                'created_at' => $this->datetime,
	            ];
	            
	            $this->productBrandModel->save($data);
	        }
	    }
	    
	    return redirect('product_brand')->with('status', 'Product brands updated successfully');
	}
	
	public function delete_product_brand($id = 0) {
	    $delete = $this->productBrandModel->where('product_brand_id', $id)->delete();
	    
	    if ($delete) {
	        return redirect('product_brand')->with('status', 'Product brand deleted successfully');
	    } else {
	        return redirect('product_brand')->with('status', 'Failed to delete the product brand');
	    }
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function product_category() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Set Product Category']),
			'page_title' => view('partials/page-title', ['title' => 'Set Product Category', 'li_1' => 'Dashboard', 'li_2' => 'Set Product Category']),
			'categories' => $this->productCategoryModel->findAll(),
		];
		
		return view('products/product-categories', $data);
	}
	
	public function update_product_category() {
	    $product_category_id = $this->request->getPost('product_category_id');
	    $category_name = $this->request->getPost('category_name');
	    
	    for ($i = 0; $i < COUNT($category_name); $i++) {
	        if (array_key_exists($i, $product_category_id)) {
	            $data = [
	                'category_name' => $category_name[$i],
	            ];
	            
	            $this->productCategoryModel->update($product_category_id[$i], $data);
	        } else {
	            $data = [
	                'category_name' => $category_name[$i],
	                'created_at' => $this->datetime,
	            ];
	            
	            $this->productCategoryModel->save($data);
	        }
	    }
	    
	    return redirect('product_category')->with('status', 'Product categories updated successfully');
	}
	
	public function delete_product_category($id = 0) {
	    $delete = $this->productCategoryModel->where('product_category_id', $id)->delete();
	    
	    if ($delete) {
	        return redirect('product_category')->with('status', 'Product category deleted successfully');
	    } else {
	        return redirect('product_category')->with('status', 'Failed to delete the product category');
	    }
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function product_size() {
	    $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Set Product Size']),
			'page_title' => view('partials/page-title', ['title' => 'Set Product Size', 'li_1' => 'Dashboard', 'li_2' => 'Set Product Size']),
			'sizes' => $this->productSizeModel->findAll(),
		];
		
		return view('products/product-sizes', $data);
	}
	
	public function update_product_size() {
	    $product_size_id = $this->request->getPost('product_size_id');
	    $size_name = $this->request->getPost('size_name');
	    
	    for ($i = 0; $i < COUNT($size_name); $i++) {
	        if (array_key_exists($i, $product_size_id)) {
	            $data = [
	                'size_name' => $size_name[$i],
	            ];
	            
	            $this->productSizeModel->update($product_size_id[$i], $data);
	        } else {
	            $data = [
	                'size_name' => $size_name[$i],
	                'created_at' => $this->datetime,
	            ];
	            
	            $this->productSizeModel->save($data);
	        }
	    }
	    
	    return redirect('product_size')->with('status', 'Product sizes updated successfully');
	}
	
	public function delete_product_size($id = 0) {
	    $delete = $this->productSizeModel->where('product_size_id', $id)->delete();
	    
	    if ($delete) {
	        return redirect('product_size')->with('status', 'Product size deleted successfully');
	    } else {
	        return redirect('product_size')->with('status', 'Failed to delete the product size');
	    }
	}
	
	////////////////////////////////////////////////////////////////////////////
}
