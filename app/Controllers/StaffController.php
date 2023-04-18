<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Staff;

class StaffController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->staffModel = new Staff();
    }
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Staff List']),
			'page_title' => view('partials/page-title', ['title' => 'Staff List', 'li_1' => 'Dashboard', 'li_2' => 'Staff List']),
			'staffs' => $this->staffModel->where('role != 0')->findAll(),
		];
		return view('staffs/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Staff']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Staff', 'li_1' => 'Dashboard', 'li_2' => 'Staff List', 'li_3' => 'Add New Staff'])
		];

		return view('staffs/add-form', $data);
	}

	public function save_add()
	{
		$data = [
		    'username' => $_POST['username'] ?? "",
		    'password' => $_POST['password'] ?? "",
		    'name' => $_POST['name'] ?? "",
		    'phone' => $_POST['phone'] ?? "",
		    'created_at' => $this->datetime,
		    'role' => $_POST['role'],
		];

		$this->staffModel->save($data);

		return redirect('staff')->with('status', 'Staff inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Staff']),
			'page_title' => view('partials/page-title', ['title' => 'Update Staff', 'li_1' => 'Dashboard', 'li_2' => 'Staff List', 'li_3' => 'Update Staff']),
			'staff' => $this->staffModel->find($id)
		];

		return view('staffs/edit-form', $data);
	}

	public function save_update($id = null)
	{
		$data = [
		    'username' => $_POST['username'] ?? "",
		    'password' => $_POST['password'] ?? "",
		    'name' => $_POST['name'],
		    'phone' => $_POST['phone'] ?? "",
		    'role' => $_POST['role'],
		];
		$this->staffModel->update($id, $data);

		return redirect('staff')->with('status', 'Staff updated Successfully');
	}

	public function delete_staff($id = null)
	{
		$this->staffModel->delete($id);

		return redirect('staff')->with('status', 'Staff deleted Successfully');
	}
}
