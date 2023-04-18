<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Workshop;

class WorkshopController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->workshopModel = new Workshop();
    }
    
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Workshop List']),
			'page_title' => view('partials/page-title', ['title' => 'Workshop List', 'li_1' => 'Dashboard', 'li_2' => 'Workshop List']),
			'workshops_data' => $this->workshopModel->findAll(),
		];
		return view('workshops/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Workshop']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Workshop', 'li_1' => 'Dashboard', 'li_2' => 'Workshop List', 'li_3' => 'Add New Workshop']),
		];

		return view('workshops/add-form', $data);
	}

	public function save_add()
	{
		$data = [
		    'name' => $_POST['name'],
		    'phone' => $_POST['phone'],
		    'created_at' => $this->datetime
		];

		$this->workshopModel->save($data);
		$workshop_id = $this->workshopModel->insertID();
		
		$this->workshopModel->set('workshop_unique_id', $workshop_id)->where('workshop_id', $workshop_id)->update();

		return redirect('workshop')->with('status', 'Workshop inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Workshop']),
			'page_title' => view('partials/page-title', ['title' => 'Update Workshop', 'li_1' => 'Dashboard', 'li_2' => 'Workshop List', 'li_3' => 'Update Workshop']),
			'workshop' => $this->workshopModel->find($id),
		];

		return view('workshops/edit-form', $data);
	}

	public function save_update($id = null)
	{
		$data = [
		    'workshop_unique_id' => $id,
		    'name' => $_POST['name'],
		    'phone' => $_POST['phone'],
		];
		$this->workshopModel->update($id, $data);

		return redirect('workshop')->with('status', 'Workshop updated Successfully');
	}

	public function delete_workshop($id = null)
	{
		$this->workshopModel->delete($id);

		return redirect('workshop')->with('status', 'Workshop deleted Successfully');
	}
}
