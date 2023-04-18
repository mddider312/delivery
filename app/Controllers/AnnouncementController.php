<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Announcement;

class AnnouncementController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->announcementModel = new Announcement();
    }
    
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Announcement List']),
			'page_title' => view('partials/page-title', ['title' => 'Announcement List', 'li_1' => 'Dashboard', 'li_2' => 'Announcement List']),
			'announcements_data' => $this->announcementModel->orderBy('announcement_id ', 'DESC')->findAll(),
		];
		return view('announcements/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New Announcement']),
			'page_title' => view('partials/page-title', ['title' => 'Add New Announcement', 'li_1' => 'Dashboard', 'li_2' => 'Announcement List', 'li_3' => 'Add New Announcement']),
		];

		return view('announcements/add-form', $data);
	}

	public function save_add()
	{
	    $img        = $this->request->getFile('photo') ?? null;
	    $image_name = "";
	    
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            
            if ($img->move(ROOTPATH . 'public/uploads/announcements', $newName)) {
                $image_name = $newName;
            }
        }
	    
		$data = [
		    'photo' => $image_name,
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'created_at' => $this->datetime,
		];

		$result = $this->announcementModel->save($data);
        
        if ($result) {
            return redirect('announcement')->with('status', 'Announcement inserted Successfully');
        } else {
            return redirect('announcement')->with('status', 'Failed to insert announcement');
        }
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update Announcement']),
			'page_title' => view('partials/page-title', ['title' => 'Update Announcement', 'li_1' => 'Dashboard', 'li_2' => 'Announcement List', 'li_3' => 'Update Announcement']),
			'announcement' => $this->announcementModel->find($id),
		];

		return view('announcements/edit-form', $data);
	}

	public function save_update($id = null)
	{
	    $img        = $this->request->getFile('photo') ?? null;
	    $image_name = "";
	    
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            
            if ($img->move(ROOTPATH . 'public/uploads/announcements', $newName)) {
                $image_name = $newName;
            }
        }
	    
		$data = [
		    'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
		];
		
		if ($image_name != "") {
		    $data['photo'] = $image_name;
		}
		
		$this->announcementModel->update($id, $data);

		return redirect('announcement')->with('status', 'Announcement updated Successfully');
	}

	public function delete_Announcement($id = null)
	{
		$this->announcementModel->delete($id);

		return redirect('announcement')->with('status', 'Announcement deleted Successfully');
	}
	
	public function delete_announcement_photo($id = null)
	{
		$this->announcementModel->update($id, [
		    'photo' => null
		]);
		
		return redirect()->back()->with('status', 'Announcement photo deleted Successfully');
	}
}
