<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppId;
use App\Models\AppId_Area;

class AppIdController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
        $this->appIdModel = new AppId();
        $this->appIdAreaModel = new AppId_Area();
    }
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'AppID List']),
			'page_title' => view('partials/page-title', ['title' => 'AppID List', 'li_1' => 'Dashboard', 'li_2' => 'AppID List']),
			'appids' => $this->appIdModel->orderBy("appid_id", "DESC")->findAll(),
		];
		return view('app_id/index', $data);
	}

	public function add_form()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Add New AppID']),
			'page_title' => view('partials/page-title', ['title' => 'Add New AppID', 'li_1' => 'Dashboard', 'li_2' => 'AppID List', 'li_3' => 'Add New AppID'])
		];

		return view('app_id/add-form', $data);
	}

	public function save_add()
	{
	    $appid = $_POST['appid'];
	    $appid_areas = $_POST['appid_area'];
	    
		$data = [
		    'appid' => $appid ?? "",
		    'created_at' => $this->datetime,
		];

		$save = $this->appIdModel->save($data);
		
		$appid_id = $this->appIdModel->insertID();
		
		foreach ($appid_areas as $appid_area) {
		    $this->appIdAreaModel->save([
		        "appid_id" => $appid_id,
		        "appid_area" => $appid_area,
		        "created_at" => $this->datetime,
		    ]);
		}

		return redirect('appid')->with('status', 'AppID inserted Successfully');
	}

	public function update_form($id = null)
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Update AppID']),
			'page_title' => view('partials/page-title', ['title' => 'Update AppID', 'li_1' => 'Dashboard', 'li_2' => 'AppID List', 'li_3' => 'Update AppID']),
			'appid' => $this->appIdModel->find($id),
			'areas' => $this->appIdAreaModel->where("appid_id", $id)->findAll(),
		];

		return view('app_id/edit-form', $data);
	}

	public function save_update($id = null)
	{   
	    $appid = $_POST['appid'];
	    $appid_area_ids = $_POST['appid_area_id'] ?? [];
	    $appid_areas = $_POST['appid_area'];
	    
	    $this->appIdModel->update($id, ["appid" => $appid]);
	    
	    for ($i = 0; $i < COUNT($appid_areas); $i++) {
	        if ($appid_area_ids == "") {
	            $this->appIdAreaModel->save([
    		        "appid_id" => $id,
    		        "appid_area" => $appid_areas[$i],
    		        "created_at" => $this->datetime,
    		    ]);
	        } else {
	            if (array_key_exists($i, $appid_area_ids)) {
    	            $data = [
    	                'appid_area' => $appid_areas[$i],
    	            ];
    	            
    	            $this->appIdAreaModel->update($appid_area_ids[$i], $data);
    	        } else {
    	            $this->appIdAreaModel->save([
        		        "appid_id" => $id,
        		        "appid_area" => $appid_areas[$i],
        		        "created_at" => $this->datetime,
        		    ]);
    	        }
	        }
	    }      
	    
		return redirect('appid')->with('status', 'AppID updated Successfully');
	}

	public function delete_appid($id = null)
	{
		$this->appIdModel->delete($id);
		$this->appIdAreaModel->where("appid_id", $id)->delete();

		return redirect('appid')->with('status', 'AppID deleted Successfully');
	}
	
	public function delete_appid_area($appid_id = null, $appid_area_id = null)
	{
		$this->appIdAreaModel->where("appid_area_id", $appid_area_id)->delete();

		return redirect()->back()->with('status', 'AppID deleted Successfully');
	}
}
