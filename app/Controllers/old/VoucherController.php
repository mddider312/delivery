<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Voucher;

class VoucherController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->voucherModel = new Voucher();
    }
    
	public function index()
	{
        $vouchers_data = $this->voucherModel->findAll();

		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Voucher List']),
			'page_title' => view('partials/page-title', ['title' => 'Voucher List', 'li_1' => 'Dashboard', 'li_2' => 'Voucher List']),
			'vouchers_data' => $vouchers_data
		];
		return view('vouchers/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Voucher']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Voucher', 'li_1' => 'Dashboard', 'li_2' => 'Voucher List', 'li_3' => 'Add New Voucher'])
		];
		return view('vouchers/add-form', $data);
	}

	public function save_add()
	{
		$data = [
			'name' => $_POST['name'],
			'code' => $_POST['code'],
			'type' => $_POST['type'],
			'discount_amount' => $_POST['discount_amount']
		];

		$this->voucherModel->save($data);

		return redirect('voucher')->with('status', 'Voucher inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Voucher']),
			'page_title' => view('partials/page-title', ['title' => 'Update Voucher', 'li_1' => 'Dashboard', 'li_2' => 'Voucher List', 'li_3' => 'Update Voucher']),
			'voucher' => $this->voucherModel->find($id)
		];

		return view('vouchers/edit-form', $data);
	}

	public function save_update($id = null)
	{
		$data = [
			'name' => $_POST['name'],
			'code' => $_POST['code'],
			'type' => $_POST['type'],
			'discount_amount' => $_POST['discount_amount']
		];
		$this->voucherModel->update($id, $data);

		return redirect('voucher')->with('status', 'Voucher updated Successfully');
	}

	public function delete_voucher($id = null)
	{
		$this->voucherModel->delete($id);

		return redirect('voucher')->with('status', 'Voucher deleted Successfully');
	}
}

